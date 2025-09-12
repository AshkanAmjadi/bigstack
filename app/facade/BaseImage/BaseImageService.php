<?php


namespace App\facade\BaseImage;


use App\facade\BaseMethod\BaseMethod;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class BaseImageService
{

    public $imgCan = ['jpg', 'jpeg', 'png', 'webp','gif'];
    public function baseSetOptionImg($object, $type, $request, $data, $typeOfImage, $objectParam = 'id')
    {
        $dirPath = 'image/' . $type . '/' . $object->toArray()[$objectParam] . '/' . $typeOfImage;

        deleteDirIfExist(filePathMaker($dirPath));

        $newdata = $this->saveImage($request, $object, $dirPath, $data, $typeOfImage);

        $mainData['value']['ext'] = $newdata[$typeOfImage]['ext'];

        $object->update($mainData);


    }
    //todo compile all Base Delete images method

    public function baseDeleteImg($object, $type)
    {

        deleteDirIfExist(filePathMaker('image/' . $object->getTable() . '/' . $object->hash_id . "/" . $type));

        $object->update([$type => null]);
    }


    public function saveEditorJsImages( $object,  $data)
    {
        $editorContent = json_decode($data, true);


        $table = $object->getTable();
        $path = "/image/$table/$object->hash_id";
        $dir = app('path.public') .$path;
        if (!File::isDirectory($dir)){
            File::makeDirectory($dir,0777,true,true);
        }
        if (!File::isDirectory($dir."/description")){
            File::makeDirectory($dir."/description",0777,true,true);
        }
        $allFiles = File::allFiles(app('path.public')."/image/$table/$object->hash_id/description");


        foreach ($editorContent as $key => $item) {

            $type = $item['type'];

            if ($type === 'image') {

                $code = $item['data']['url'];

                if (!File::exists(app('path.public').$code)){
                    $base64 = explode(';base64,',  $code);
                    $content = $base64[1];
                    $exploded = explode('/',$base64[0]);
                    $data = explode(':',$exploded[0])[1];
                    $ext = $exploded[1];

                    if ($data !== 'image') {
                        Log::warning(auth()->id() . 'user by this id try to send bad file');
                        return false;
                    }
                    if (!in_array($ext, $this->imgCan)) {
                        Log::warning(auth()->id() . 'user by this id try to send bad file');
                        return false;
                    }



                    $random = Str::random(6);
                    File::put($dir."/description/$random.".$ext , base64_decode($content));

                    $editorContent[$key]['data']['url'] = $path."/description/$random.".$ext;
                }else{

                    foreach ($allFiles as $key => $file) {
                        if ($file->getBasename() === File::basename(app('path.public').$code)){
                            unset($allFiles[$key]);
                        }
                    }


                }


            }
        }


        foreach ($allFiles as $key => $file) {
            File::delete($file->getPathname());
        }

        return json_encode($editorContent);

    }

    public function saveBase64image($base64 , $object , $type,$lower = false, $width = null,$height = null,$semantic = false,$attr = 'slug',$pathInPublic = 'image')
    {


        if ($semantic){

            $semanticName = singleRemoveSpace($object->getAttribute($attr),'-') ;
        }


        if ($base64) {
            $base64 = explode(';base64,',  $base64);
            $content = $base64[1];
            $exploded = explode('/',$base64[0]);
            $data = explode(':',$exploded[0])[1];
            $ext = $exploded[1];

            if ($data !== 'image') {
                Log::warning(auth()->id() . 'user by this id try to send bad file');
                return false;
            }
            if (!in_array($ext, $this->imgCan)) {
                Log::warning(auth()->id() . 'user by this id try to send bad file');
                return false;
            }


            $table = $object->getTable();
            $dir = app('path.public') ."/$pathInPublic/$table/$object->hash_id";
            if (!File::isDirectory($dir)){
                File::makeDirectory($dir,0777,true,true);
            }
            if (File::isDirectory($dir."/$type")){
                File::deleteDirectory($dir."/$type");
                File::makeDirectory($dir."/$type",0777,true,true);
            }else{
                File::makeDirectory($dir."/$type",0777,true,true);
            }


            if ($semantic){
                File::put($dir."/$type/$semanticName.".$ext , base64_decode($content));

                $mangere = new ImageManager(
                    new Driver()
                );
                $image = $mangere->read($dir."/$type/$semanticName.".$ext);

                if ($width and $height){
                    $image->resize($width,$height);
                    $image->save($dir."/$type/$semanticName.".$ext);

                }


                $object->update([$type => $semanticName.'.'. $ext ]);

            }else{

                File::put($dir."/$type/$type.".$ext , base64_decode($content));
                $mangere = new ImageManager(
                    new Driver()
                );
                $image = $mangere->read($dir."/$type/$type.".$ext);

                if ($width and $height){
                    $image->resize($width,$height);
                    $image->save($dir."/$type/$type.".$ext);

                }
                $object->update([$type => $ext ]);


            }
            return true;
        }else{

            if ($semantic and isset($object->getChanges()[$attr])){
                $table = $object->getTable();
                $img = $object->getAttribute($type);
                $base = app('path.public') ."/$pathInPublic/$table/$object->hash_id/$type/";
                $dir = $base ."$img";


                if (File::exists($dir)){
                    $ext = File::extension($dir);
                    File::move($dir, $base ."$semanticName.$ext");
                    $object->update([$type => $semanticName.'.'. $ext ]);
                    return true;

                }else{
                    File::deleteDirectory($base);
                    $object->update([$type => null ]);
                }
                return false;
            }
            return false;
        }


//todo save thumbnail
//        $img = \Intervention\Image\Facades\Image::make(public_path('laravel.png'));
//
//        $img->resize(300,300)->save(public_path('laravel.webp'));
//        dd('d');
    }




}

<?php


namespace App\facade\Description;


use App\facade\BaseValidation\BaseValidation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class DescriptionService
{


    public function makeValid($request)
    {

//                dd($request->all());

        $inpForVal = $this->removeIrRelevant($request);


        foreach ($inpForVal as $key => $value) {


            if (getFirstKey($value) === 'title') {

                if (getFirstKey($value['title']) === 'big') {

                    //validbigtitle
                    $validation = $this->validTitle($value['title'],'big');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }



                } elseif (getFirstKey($value['title']) === 'medium') {

                    //validmediumtitle
                    $validation = $this->validTitle($value['title'],'medium');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }


                } elseif (getFirstKey($value['title']) === 'tiny') {

                    //validtinytitle
                    $validation = $this->validTitle($value['title'],'tiny');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }


                } else {
                    return $this->prepareForSendArticle($request,false);
                }

            } elseif (getFirstKey($value) === 'paragraph') {

                //validparagraph
                $validation = $this->validParagraph($value,'paragraph');
                if ($validation->fails()){
                    return $this->prepareForSendArticle($request,$validation,true);
                }

            } elseif (getFirstKey($value) === 'point') {

                if (getFirstKey($value['point']) === 'blue') {

                    //validBluePoint
                    $validation = $this->validPoint($value['point'],'blue');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }


                } elseif (getFirstKey($value['point']) === 'green') {

                    $validation = $this->validPoint($value['point'],'green');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }

                } elseif (getFirstKey($value['point']) === 'red') {

                    $validation = $this->validPoint($value['point'],'red');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }

                } elseif (getFirstKey($value['point']) === 'yellow') {

                    $validation = $this->validPoint($value['point'],'yellow');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }

                } elseif (getFirstKey($value['point']) === 'grey') {

                    $validation = $this->validPoint($value['point'],'grey');
                    if ($validation->fails()){
                        return $this->prepareForSendArticle($request,$validation,true);
                    }

                } else {
                    return $this->prepareForSendArticle($request,false);
                }

            } elseif (getFirstKey($value) === 'list') {

                $validation = $this->validList($value,'list');
                if ($validation->fails()){
                    return $this->prepareForSendArticle($request,$validation,true);
                }

            } elseif (getFirstKey($value) === 'link') {

                $validation = $this->validLink($value['link']);
                if ($validation->fails()){
                    return $this->prepareForSendArticle($request,$validation,true);
                }

            } elseif (getFirstKey($value) === 'gallery') {


                foreach ($value['gallery'] as $galKey => $gal){

                    if (!BaseValidation::pregForNum($galKey)){
                        return $this->prepareForSendArticle($request,false);
                    }

                    $firstKey = getFirstKey($gal);

                    if ($firstKey === 'tiny'){
                        if (count($gal[$firstKey]) === 3){

                            $i = 1;

                            foreach ($gal[$firstKey] as $picKey => $pic){

                                if ($picKey != $i){
                                    return $this->prepareForSendArticle($request,false);
                                }

                                $i++;

                                $validation = $this->validPic($pic);
                                if ($validation->fails()){
                                    return $this->prepareForSendArticle($request,$validation,true);
                                }
                            }

                        }else{
                            return $this->prepareForSendArticle($request,false);
                        }
                    }elseif ($firstKey === 'medium'){
                        if (count($gal[$firstKey]) === 2){

                            $i = 1;

                            foreach ($gal[$firstKey] as $picKey => $pic){

                                if ($picKey != $i){
                                    return $this->prepareForSendArticle($request,false);
                                }

                                $i++;

                                $validation = $this->validPic($pic);
                                if ($validation->fails()){
                                    return $this->prepareForSendArticle($request,$validation,true);
                                }

                            }

                        }else{
                            return $this->prepareForSendArticle($request,false);
                        }
                    }elseif ($firstKey === 'big'){

                        if (count($gal[$firstKey]) === 1){

                            $i = 1;

                            foreach ($gal[$firstKey] as $picKey => $pic){


                                if ($picKey != $i){
                                    return $this->prepareForSendArticle($request,false);
                                }

                                $i++;

                                $validation = $this->validPic($pic);
                                if ($validation->fails()){
                                    return $this->prepareForSendArticle($request,$validation,true);
                                }

                            }

                        }else{
                            return $this->prepareForSendArticle($request,false);
                        }
                    }else{
                        return $this->prepareForSendArticle($request,false);
                    }

                }


            } else {
                return $this->prepareForSendArticle($request,false);
            }

        }



        return $this->prepareForSendArticle($request);

    }

    private function removeIrRelevant($request)
    {
        $inputs = $request->all();

        unset($inputs['_method']);
        unset($inputs['_token']);
        unset($inputs['sortofpictur']);


        return $inputs;
    }
    private function prepareForSendArticle($request,$validation = [],$fails = false)
    {

        $sort = $request->sortofpictur;
        $inputs = $this->removeIrRelevant($request);

        if ($validation === false){

            return ['status' => false , 'redirect' => back()->with('allInputs', $inputs)->with('sort', $sort)];

        }elseif ($fails){

            return ['status' => false , 'redirect' => back()->with('allInputs', $inputs)->with('sort', $sort)->withErrors($validation)];

        }

//        return ['status' => false , 'redirect' => back()->with('allInputs', $inputs)->with('sort', $sort)];

        return ['status' => true , 'inputs' => $inputs];

    }



    public function setChanges($request,$obj,$model,$returned)
    {

        $result = $this->deletGalleryInEdit($request, $obj, $model);

        if ($result['status']) {
            $update = ['description' => $returned['inputs'], 'desc_gallery' => $result['desc_gallery']];
        } else {
            $update = ['description' => $returned['inputs']];
        }


        $obj->update($update);

        toast('توضیحات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();
    }

    public function setGalleryChanges($request,$obj,$model)
    {

        $data = $this->makeValidDescGallery($request, true);


        if (!$this->hasDescGall($obj)) {
            $newdata = [];
        } else {

            $result = $this->findImageGall($obj, $data['gallId'], $data['rowId'], $data['size'], $data['num'], true);

            if (is_array($result)) {
                $newdata = $result['data'];
            } elseif (!$result) {
                $newdata = $obj->desc_gallery;
            }

        }


        $data = $this->saveImageGall($data, $model, $obj);

        array_push($newdata, $data);

        $obj->update(['desc_gallery' => $newdata]);


        toast('عکس برای توضیحات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

    }
    public function deleteDescGallery($request,$obj,$model)
    {

        $data = $this->makeValidDescGallery($request);


        $result = $this->findImageGall($obj, $data['gallId'], $data['rowId'], $data['size'], $data['num'], true);

        if (is_array($result)) {

            $this->deleteImageGall($data, $model, $obj, $result['gal']['picture']['ext']);

            $obj->update(['desc_gallery' => $result['data']]);

            toast('عکس پاک شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        }

    }

    public function hasDescGall($obj)
    {
        return $obj->desc_gallery !== null;
    }


        private function validTitle($obj,$type)
    {
        $validation = Validator::make($obj, [
            $type => [
                'string',
                'required',
                'max:30'
            ]
        ]);

        return $validation;
    }
    private function validParagraph($obj,$type)
    {
        $validation = Validator::make($obj, [
            $type => [
                'string',
                'required',
                'max:3000'
            ]
        ]);

        return $validation;
    }
    private function validPoint($obj,$type)
    {
        $validation = Validator::make($obj, [
            $type => [
                'string',
                'required',
                'max:1000'
            ]
        ]);

        return $validation;
    }
    private function validList($obj,$type)
    {
        $validation = Validator::make($obj, [
            $type => [
                'string',
                'required',
                'max:1000'
            ]
        ]);

        return $validation;
    }
    private function validLink($obj)
    {
        $validation = Validator::make($obj, [
            'name' => [
                'string',
                'required',
                'max:60',
            ],
            'url' => [
                'string',
                'required',
                'max:300',
                'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'
            ]
        ]);

        return $validation;
    }
    private function validPic($pic)
    {
//        $validation = Validator::make(['pic'=>$pic] , [
//            'pic' => 'required|file|image|mimes:jpg,jpeg,png,gif,webp|max:1024',
//        ]);
        $validation = Validator::make(['pic'=>$pic] , [
            'pic' => [
                'string',
                'required',
                Rule::in('picture')
            ]
        ]);

        return $validation;
    }


    //TODO set validVideo


    public function saveImages($inputs,$filename,$descFor)
    {


        $first = $inputs;

        foreach ($inputs as $key => $input){
            $typeInput = getFirstKey($input);
            if ($typeInput === 'gallery'){
                foreach ($input['gallery'] as $galKey => $gal){

                    $fileSize = getFirstKey($gal);

                    foreach ($gal[$fileSize] as $picKey => $pic){
                        $ext = $pic->getClientOriginalExtension();

                        $name = $picKey .'.'. $ext ;
                        $url = '/image/'.$filename.'/'.$descFor.'/description/'.$key.'/'.$galKey.'/'.$fileSize.'/';

                        moveImage($pic,$url,$name);

                        $inputs[$key][$typeInput][$galKey][$fileSize][$picKey] = $ext;
                    }


                }
            }
        }

    }

    public function hasGallery($desc)
    {
        if ($this->getGallery($desc)){
            return true;
        }else{
            return false;
        }
    }

    public function getGalleryRows($inputs,$desc_gallery = false)
    {
        $galleryRows = [];
        $descGallery = [];


        foreach ($inputs as $galKey => $gal){
            if (getFirstKey($gal)==='gallery'){

                foreach ($gal['gallery'] as $rowKey => $row){

                    $galleryRows[$rowKey] = $row;

                    if ($desc_gallery){
                        $fileSize = getFirstKey($row);

                        foreach ($row[$fileSize] as $picKey => $pic){

                            $descGallery[$rowKey][$picKey] = [
                                'gallId' => $galKey,
                                'rowId' => $rowKey,
                                'size' => $fileSize,
                                'num' => $picKey
                            ];

                        }

                    }

                }

            }

        }

        if ($desc_gallery){
            if ($descGallery === []){
                return false;
            }

            return $descGallery;
        }

        if ($galleryRows === []){
            $galleryRows = false;
        }

        return $galleryRows;
    }


    public function getGallery($inputs)
    {
        $gallerys = [];



        foreach ($inputs as $key => $input){
            if (getFirstKey($input)==='gallery'){

                $gallerys[$key] = $input;

            }

        }

        if ($gallerys === []){
            $gallerys = false;
        }

        return $gallerys;

    }

    public function getLastSort($inputs)
    {

        $galRow = $this->getGalleryRows($inputs);
        ksort($galRow,SORT_NUMERIC);

        if (!$galRow){
            return 0;
        }else{
            return getLastKey($galRow);
        }
    }
    //TODO saveVideoMethod
//    public function saveVideo()
//    {
//
//    }
    public function saveImageGall($data,$filename,$subject)
    {


        $ext = $data['picture']->getClientOriginalExtension();

        $name = $data['gallId'].'_'.$data['rowId'].'_'.$data['size'].'_'.$data['num'] .'.'. $ext ;
        $url = '/image/'.$filename.'/'.$subject->id.'/desc_gallery/';

        moveImage($data['picture'],$url,$name);

        $data['picture'] = ['ext'=>$ext];

        return $data;
    }


    public function findImageGall($subject,$galKey,$rowKey,$size,$picKey,$unset = false)
    {

        if (is_object($subject)){
            $allGallerys = $subject->desc_gallery;
            if ($allGallerys === null){
                return false;
            }
        }elseif (is_array($subject) and $subject !== []){
            $allGallerys = $subject;
        }else{
            return false;
        }




        foreach ($allGallerys as $gallKey=>$gal){
            if ($galKey == $gal['gallId'] and $rowKey == $gal['rowId'] and $size == $gal['size'] and $picKey == $gal['num']){

                if ($unset){
                    $deletedGallery = $gal;
                    unset($allGallerys[$gallKey]);

                    return ['data' => $allGallerys , 'gal' => $deletedGallery];
                }

                return $gal;

            }
        }

        return false;
    }


    public function findImageGallWithPath($subject,$galKey,$rowKey,$size,$picKey,$model,$asset = false)
    {
        $gal = $this->findImageGall($subject,$galKey,$rowKey,$size,$picKey);


        if (!$gal){
            return false;
        }

        $path = 'image/'.$model.'/'.$subject->id.'/desc_gallery/'.$galKey.'_'.$rowKey.'_'.$size.'_'.$picKey.'.'.$gal['picture']['ext'];
        if ($asset){
            return $path;
        }else{
            return filePathMaker($path);
        }

    }

    public function deletGalleryInEdit($request,$subject,$model)
    {



        if ($subject->description === null){
            return ['status' => false];
        }
        if (!$this->hasGallery($subject->description)){
            return ['status' => false];
        }

        $nextGallRow = $this->getGalleryRows($this->removeIrRelevant($request),true);
        $prevGallRow = $this->getGalleryRows($subject->description,true);

        $nextGallRow = $nextGallRow ? $nextGallRow : [] ;

        $deletedGallRow = array_diff_key($prevGallRow,$nextGallRow);

        if ($deletedGallRow === []){
            return ['status' => false];
        }

        $lastDescGalleryToSave = $subject->desc_gallery;
        $deletedpics = [];

//        dd($lastDescGalleryToSave);
        foreach ($deletedGallRow as $rowKey=> $row){
            foreach ($row as $picInfo){

                $result = $this->findImageGall($lastDescGalleryToSave,$picInfo['gallId'],$picInfo['rowId'],$picInfo['size'],$picInfo['num'],true);

                if ($result){
                    array_push($deletedpics,$result['gal']);
                    $lastDescGalleryToSave = $result['data'];

                    $deletedpic = $result['gal'];

                    $this->deleteImageGall($deletedpic,$model,$subject,$result['gal']['picture']['ext']);
                }


            }
        }


        return ['status' => true,'desc_gallery' => $lastDescGalleryToSave];


    }
    public function deleteImageGall($data,$filename,$subject,$ext)
    {

        deleteFileIfExist(filePathMaker('image/'.$filename.'/'.$subject->id.'/desc_gallery/'.$data['gallId'].'_'.$data['rowId'].'_'.$data['size'].'_'.$data['num'].'.'.$ext));

    }

    public function makeValidDescGallery($request,$set = false)
    {

        $validate = [

            'gallId' => 'required|integer|max:300',
            'rowId' => 'required|integer|max:300',
            'size' => [ 'string' , 'required' , Rule::in('medium','tiny','big')],
            'num' => ['integer','required',Rule::in('1','2','3')],

        ];

        if ($set){

            $validate['picture'] = 'required|file|image|mimes:jpg,jpeg,png,gif,webp|max:1024';
        }

        return $request->validate($validate);

    }



}

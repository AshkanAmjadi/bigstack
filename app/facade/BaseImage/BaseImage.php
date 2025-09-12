<?php


namespace App\facade\BaseImage;


use Illuminate\Support\Facades\Facade;
/**
 * Class BaseMethod
 * @method static string baseSetIcon(collection $object,string $type,collection $request,array $data)
 * @method static string baseSetOptionImg($object,$type,$request,$data,$typeOfImage,$objectParam = 'id')
 * @method static string baseSetBanner(collection $object,string $type,collection $request,array $data)
 * @method static string baseSetImg(collection $object,string $type,collection $request,array $data)
 * @method static string baseSetGallery(collection $object,collection $galleryObject,string $type,collection $request,array $data)
 * @method static string baseDeleteIcon(collection $object , string $type)
 * @method static string baseDeleteBanner(collection $object , string $type)
 * @method static string baseDeleteImg(collection $object , string $type)
 * @method static string saveEditorJsImages(collection $object , array $data)
 * @method static string saveBase64image(string $base64 ,collection $object, string $type,$lower = false,$width = null ,$height = null,$semantic = false,$attr = 'slug')
 *
 * @see \App\facade\BaseImage\BaseImage
 */
class BaseImage extends Facade
{


    protected static function getFacadeAccessor()
    {
        return 'BaseImageService';

    }

}

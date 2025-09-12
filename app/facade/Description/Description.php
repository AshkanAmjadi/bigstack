<?php


namespace App\facade\Description;


use Illuminate\Support\Facades\Facade;

/**
 * Class BaseMethod
 * @method static makeValid(collection $request)
 * @method static hasGallery(array $desc)
 * @method static getGalleryRows(array $inputs)
 * @method static getGallery(array $inputs)
 * @method static getLastSort(array $inputs)
 * @method static saveImageGall(array $data,string $filename,collection $subject)
 * @method static deleteImageGall(array $data,string $filename,collection $subject, string $ext)
 * @method static findImageGall(collection $subject,integer $galKey,integer $rowKey,string $size,integer $picKey,bool $unset)
 * @method static findImageGallWithPath(collection $subject,integer $galKey,integer $rowKey,string $size,integer $picKey,string $model,bool $asset)
 * @method static deletGalleryInEdit(collection $request,collection $brand,string $model)
 * @method static makeValidDescGallery($request,$set)
 * @method static setChanges($request,$obj,$model,$returned)
 * @method static setGalleryChanges($request,$obj,$model)
 * @method static deleteDescGallery($request,$obj,$model)
 *
 * @see \App\facade\Description\Notification
 */
class Description extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'DescriptionService';
    }

}

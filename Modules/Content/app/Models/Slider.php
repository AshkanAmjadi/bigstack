<?php

namespace Modules\Content\App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class Slider extends Model
{


    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::creating(function ($model) {
            Cache::forget('homeSlider');
        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model) {
            Cache::forget('homeSlider');
            unset($model->hash_id);
        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);




        });
        static::deleting(function ($model){
            Cache::forget('homeSlider');
            deleteDirIfExist(filePathMaker('image/slider/' . $model->hash_id));


        });


    }



    protected $fillable = [
        'name',
        'type',
        'banner',
        'mobile_banner',
        'link',
        'sort',
        'follow',
    ];

    public $timestamps = false;

    protected $table = 'slider';


}

<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class WebAllert extends Model
{


    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });


        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
            Cache::forget('web_allerts');
        });
        static::updating(function ($model){
            Cache::forget('web_allerts');
        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::deleting(function ($model){
            Cache::forget('web_allerts');
        });

    }



    protected $fillable = [
        'type',
        'content',

    ];


    public $timestamps = true;

    protected $table = 'web_allert';



    public function added_by()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function updated_by()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }



    public function scopeWithUserData($query, $trashed = false)
    {
        return BaseQuery::queryWithUserData($query, $trashed);
    }




}

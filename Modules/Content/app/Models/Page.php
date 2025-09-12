<?php

namespace Modules\Content\App\Models;

use App\facade\BaseQuery\BaseQuery;
use App\Models\Lists;
use Modules\User\App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class Page extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::creating(function ($model){
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model){
            Cache::forget('page'.$model->slug);
            $model->updated_by = auth()->id();
            unset($model->hash_id);

        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });

        static::deleting(function ($model){
            deleteDirIfExist(filePathMaker('image/page/' . $model->hash_id));
            Cache::forget('page'.$model->slug);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }





    protected $fillable = [
        'title',
        'page_title',
        'meta_description',
        'keyword',
        'slug',
        'content',
        'active',
        'view',
        'added_by',
        'updated_by',
    ];

    public $timestamps = true;


    protected $table = 'page';

    public function lists()
    {
        return $this->morphMany(Lists::class, 'listable');
    }

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

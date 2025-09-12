<?php

namespace Modules\Content\App\Models;

use App\facade\BaseQuery\BaseQuery;
use App\Models\Lists;
use Modules\User\App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class Category extends Model
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
            Cache::flush();
        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model){
            Cache::flush();
            $model->updated_by = auth()->id();
            unset($model->hash_id);


        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::deleting(function ($model){
            Cache::flush();
            deleteDirIfExist(filePathMaker('image/category/' . $model->hash_id));
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }


    protected $casts = [
        'description' => 'array',
        'desc_gallery' => 'array',
    ];

    protected $fillable = [
        'title',
        'page_title',
        'mobile_banner',
        'banner',
        'icon',
        'img',
        'slug',
        'meta_description',
        'keyword',
        'parent_id',
        'added_by',
        'updated_by',
        'description',
        'desc_gallery',
    ];



    public $timestamps = true;

    protected $table = 'category';


    public function lists()
    {
        return $this->morphMany(Lists::class, 'listable');
    }


    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function scopeAllChildren($query,$firstChildes = ['id','parent_id','title','page_title'])
    {


        return $query->with([
            'child'=>function($q) use($firstChildes){
                $this->scopeAllChildren($q->select($firstChildes));
            }
        ]);

    }
    public function scopeAllParent($query,$firstParent = ['id','parent_id','title','page_title','slug'])
    {


        return $query->with([
            'parent'=>function($q) use($firstParent){
                $this->scopeAllParent($q->select($firstParent));
            }
        ]);

    }
    public function scopeAllChild($query)
    {


        return $query->with([
            'child'=>function($q){
                $this->scopeAllChild($q);
            }
        ]);

    }
    public function article()
    {
        return $this->hasMany(Article::class,'category','id');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
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

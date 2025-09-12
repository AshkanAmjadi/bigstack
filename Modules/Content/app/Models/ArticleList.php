<?php

namespace Modules\Content\App\Models;


use App\facade\BaseQuery\BaseQuery;
use Modules\User\App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class ArticleList extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->articles = explode(',',$model->articles);
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });


        static::creating(function ($model) {
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });

        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });

        static::updating(function ($model) {
            Cache::forget('articleList'.$model->slug);
            $model->updated_by = auth()->id();
            unset($model->hash_id);
            unset($model->articles);

        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });

        static::deleting(function ($model){
            Cache::forget('articleList'.$model->slug);
            deleteDirIfExist(filePathMaker('image/article_list/' . $model->hash_id));
        });
    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $fillable = [
        'title',
        'page_title',
        'meta_description',
        'keyword',
        'slug',
        'articles',
        'banner',
        'mobile_banner',
        'active',
        'added_by',
        'updated_by',

    ];

    public $timestamps = true;


    protected $table = 'article_list';



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

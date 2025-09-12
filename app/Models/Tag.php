<?php

namespace App\Models;


use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Content\App\Models\Article;
use Modules\User\App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class Tag extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::creating(function ($model) {
            Cache::flush();
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model) {

            Cache::flush();
            $model->updated_by = auth()->id();
            unset($model->hash_id);
        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::deleting(function ($model) {

            Cache::flush();
            deleteDirIfExist(filePathMaker('image/tag/' . $model->hash_id));
        });
    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $fillable = [
        'name',
        'page_title',
        'meta_description',
        'keyword',
        'banner',
        'img',
        'mobile_banner',
        'view',
        'searchable',
        'added_by',
        'updated_by',

    ];

    public $timestamps = true;


    protected $table = 'tag';





    public function article()
    {
        return $this->morphedByMany(Article::class, 'taggable','taggable');
    }
    public function insta_article()
    {
        return $this->morphedByMany(InstaArticle::class, 'taggable','taggable');
    }
    public function conversation()
    {
        return $this->morphedByMany(Conversation::class, 'taggable','taggable');
    }

    public function taggedItems(string $class)
    {
        return $this->morphedByMany($class, 'taggable', 'taggable');
    }
    public function project()
    {
        return $this->morphedByMany(Project::class, 'taggable','taggable');
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

<?php

namespace Modules\Content\App\Models;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Tact;
use App\Models\Tag;
use Modules\User\App\Models\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Vinkla\Hashids\Facades\Hashids;

class Article extends Model
{


    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::creating(function ($model){
            Cache::forget('article.newest');
            Cache::forget('article.chosen');
            $model->user_id = auth()->id();
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model){
            Cache::forget('article.newest');
            Cache::forget('article.chosen');
            BaseMethod::removeCacheDynamic($model,['tags','category','schema','added_by','related']);
            $model->updated_by = auth()->id();
            unset($model->hash_id);
        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });

        self::deleting(function ($model){
            Cache::forget('article.newest');
            Cache::forget('article.chosen');
            BaseMethod::removeCacheDynamic($model,['tags','category','schema','added_by','related']);
            deleteDirIfExist(filePathMaker('image/article/' . $model->hash_id));
            $model->tags()->detach();
            $model->stars()->delete();
            $model->likes()->delete();
            $model->marks()->delete();
            $model->comments()->each(function($comment) {
                $comment->delete(); // <-- direct deletion
            });
        });





    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    protected $casts = [
        'description' => 'array',
    ];
    protected $guarded = [
        'hash_id'
    ];


    protected $fillable = [
        'page_title',
        'title',
        'meta_description',
        'keyword',
        'slug',
        'alt',
        'caption',
        'read_time',
        'user_id',
        'category',
        'level',
        'rate',
        'description',
        'active',
        'chosen',
        'img',
        'view',
        'added_by',
        'updated_by',
    ];


    public $timestamps = true;


    protected $table = 'article';

    public function scopeChosen()
    {
        return $this->where(['chosen' => true, 'active' => true]);
    }
    public function scopeActive()
    {
        return $this->where('active', '=', true);

    }
    public function marks()
    {
        return $this->morphMany(Bookmark::class, 'mark','markable_type','markable_id','id');
    }
    public function marked()
    {
        return $this->morphMany(Bookmark::class, 'mark','markable_type','markable_id','id')->where('user_id','=',auth()->id());
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'like','likeable_type','likeable_id','id');
    }
    public function liked()
    {
        return $this->morphMany(Like::class, 'like','likeable_type','likeable_id','id')->where('user_id','=',auth()->id());
    }


    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comments','commentable_type','commentable_id','id');
    }
    public function activeComments()
    {
        return $this->morphMany(Comment::class, 'comments','commentable_type','commentable_id','id')->where('active','=',true);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function tacts()
    {
        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id');
    }
    public function stars()
    {
        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id')->where('tact_type' ,'=','star');
    }
    public function starTacts()
    {
        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id')->where('tact_type','=','star');
    }

//    public function faction()
//    {
//        return $this->hasOne(Faction::class, 'id', 'faction_id');
//    }

//todo you changh it to cat
    public function cat()
    {
        return $this->hasOne(Category::class, 'id', 'category');
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

<?php

namespace App\Models;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class Project extends Model
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
            BaseMethod::removeCacheDynamic($model,['tags','possible','plans','added_by','service','schema']);
            $model->updated_by = auth()->id();
            unset($model->hash_id);

        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        self::deleting(function ($model){
            BaseMethod::removeCacheDynamic($model,['tags','possible','plans','added_by','service','schema']);
            deleteDirIfExist(filePathMaker('image/project/' . $model->hash_id));
            $model->tags()->detach();
            $model->likes()->delete();
            $model->marks()->delete();
            $model->stars()->delete();
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


    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'page_title',
        'meta_description',
        'keyword',
        'description',
        'active',
        'img',
        'banner',
        'mobile_banner',
        'view',
        'preview_page',
        'added_by',
        'updated_by',
    ];

    public $timestamps = true;


    protected $table = 'project';

    public function stars()
    {
        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id')->where('tact_type' ,'=','star');
    }
    public function tacts()
    {
        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id');
    }
    public function starTacts()
    {
        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id')->where('tact_type','=','star');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id' , 'id');
    }
    public function possible()
    {
        return $this->belongsToMany(Possible::class,'project_possible');
    }
    public function plans()
    {
        return $this->hasMany(Plan::class,'project_id' , 'id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggable');
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


    public function comments()
    {
        return $this->morphMany(Comment::class, 'comments','commentable_type','commentable_id','id');
    }
    public function activeComments()
    {
        return $this->morphMany(Comment::class, 'comments','commentable_type','commentable_id','id')->where('active','=',true);
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

<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Modules\Content\App\Models\Article;
use Modules\User\App\Models\User;

class Usage extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        static::updating(function ($model){
            $model->updated_by = auth()->id();
        });
    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $casts = [
        'banner' => 'array',
        'img' => 'array',
        'icon' => 'array',
        'description' => 'array',
        'desc_gallery' => 'array',
    ];

    protected $fillable = [
        'name',
        'banner',
        'img',
        'icon',
        'added_by',
        'updated_by',
        'description',
        'desc_gallery',
    ];

    public $timestamps = true;


    protected $table = 'usages';

    public function marks()
    {
        return $this->morphMany(Bookmark::class, 'mark','markable_type','markable_id','id');
    }
    public function likes()
    {
        return $this->morphMany(Like::class, 'like','likeable_type','likeable_id','id');
    }
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'usageable','usageable');
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

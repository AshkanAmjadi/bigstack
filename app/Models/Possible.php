<?php

namespace App\Models;


use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;

class Possible extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
            Cache::flush();

        });
        static::updating(function ($model) {
            $model->updated_by = auth()->id();
            Cache::flush();

        });
        static::deleting(function ($model){
            Cache::flush();
        });


    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $fillable = [
        'name',
        'article_id',
        'added_by',
        'updated_by',
        'sort',


    ];

    public $timestamps = true;


    protected $table = 'possible';

    public function project()
    {
        return $this->belongsToMany(Project::class,'project_possible');
    }

    public function plan()
    {
        return $this->belongsToMany(Plan::class,'plan_possible');
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

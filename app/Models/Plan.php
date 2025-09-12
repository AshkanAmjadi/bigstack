<?php

namespace App\Models;


use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;

class Plan extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
            $project = $model->project()->first(['id']);
            BaseMethod::removeCacheDynamic($project,['tags','possible','plans','added_by','service','schema']);

        });
        static::updating(function ($model) {
            $model->updated_by = auth()->id();
            $project = $model->project()->first(['id']);
            BaseMethod::removeCacheDynamic($project,['tags','possible','plans','added_by','service','schema']);

        });
        static::deleting(function ($model) {

            $project = $model->project()->first(['id']);
            BaseMethod::removeCacheDynamic($project,['tags','possible','plans','added_by','service','schema']);

        });

    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $casts = [
        'possible' => 'array',
    ];

    protected $fillable = [
        'name',
        'product_id',
        'possible',
        'price',
        'time',
        'infinity',
        'active',
        'suggest',
        'added_by',
        'updated_by',

    ];

    public $timestamps = true;


    protected $table = 'plan';

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id' , 'id');
    }

    public function possible()
    {
        return $this->belongsToMany(Possible::class,'plan_possible');
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

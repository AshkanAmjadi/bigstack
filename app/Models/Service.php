<?php

namespace App\Models;


use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;
use Vinkla\Hashids\Facades\Hashids;


class Service extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::creating(function ($model) {
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
            Cache::forget('services');

        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model) {
            $model->updated_by = auth()->id();
            Cache::forget('services');
            unset($model->hash_id);

        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::deleting(function ($model) {
            deleteDirIfExist(filePathMaker('image/service/' . $model->hash_id));
            $model->project()->each(function($project) {
                $project->delete(); // <-- direct deletion
            });
            Cache::forget('services');

        });
    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $fillable = [
        'name',
        'purpose',
        'img',
        'banner',
        'mobile_banner',
        'url_page',
        'project_page',
        'active',
        'added_by',
        'updated_by',

    ];

    public $timestamps = true;


    protected $table = 'service';

    public function project()
    {
        return $this->hasMany(Project::class);
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

<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class Option extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);

        });
        static::creating(function ($model){
            $model->updated_by = auth()->id();
            Cache::forget('options');
        });
        static::created(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::updating(function ($model){
            $model->updated_by = auth()->id();
            Cache::forget('options');
            unset($model->hash_id);

        });
        static::updated(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
    }

    protected $fillable = [
        'name',
        'value',
        'description',
        'updated_by',
    ];

    public $timestamps = true;


    protected $table = 'options';

    public function updated_by()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function scopeWithUserData($query, $trashed = false)
    {
        return BaseQuery::queryWithUserData($query, $trashed , true);
    }
}

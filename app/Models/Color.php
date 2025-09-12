<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;

class Color extends Model
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



    protected $fillable = [
        'name',
        'hex',
        'name_fa',
        'added_by',
        'updated_by',
        'deleted_by'
    ];

    public $timestamps = true;

    protected $table = 'color';



    public function added_by()
    {
        return $this->hasOne(User::class,'id' , 'added_by');
    }
    public function updated_by()
    {
        return $this->hasOne(User::class,'id' , 'updated_by');
    }


    public function scopeWithUserData($query,$trashed = false)
    {
        return BaseQuery::queryWithUserData($query,$trashed);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;

class Tact extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){

            if (!$model->user_id){
                $model->user_id = auth()->id();
            }

        });
    }
    protected $fillable = [
        'user_id',
        'tactable_id',
        'tactable_type',
        'tact_type',
        'tact_value',
    ];

    public $timestamps = false;

    protected $table = 'tacts';


    public function tactable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class,'id','user_id');
    }

}

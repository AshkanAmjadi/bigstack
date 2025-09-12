<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;

class Like extends Model
{

//یک تریت بگو هوش مصنوعی برات بنویسه
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    public $timestamps = false;

    protected $table = 'likes';


    public function likeable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}

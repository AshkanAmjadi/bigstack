<?php

namespace Modules\User\App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAllert extends Model
{


    protected static function boot()
    {
        parent::boot();


    }



    protected $fillable = [
        'type',
        'user_id',
        'new',
        'content',
    ];


    public $timestamps = true;

    protected $table = 'user_allert';



    public function user()
    {
        return $this->belongsTo(User::class,'user_id' , 'id');
    }






}

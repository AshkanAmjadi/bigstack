<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAllert extends Model
{


    protected static function boot()
    {
        parent::boot();

    }



    protected $fillable = [
        'type',
        'content',
        'new',
    ];


    public $timestamps = true;

    protected $table = 'admin_allert';






}

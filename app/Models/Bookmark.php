<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{

    protected $fillable = [
        'user_id',
        'markable_id',
        'markable_type',
    ];

    public $timestamps = false;

    protected $table = 'bookmarks';


    public function markable()
    {
        return $this->morphTo();
    }

}

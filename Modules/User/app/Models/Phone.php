<?php

namespace Modules\User\App\Models;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use App\facade\Module\ModuleFacade;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected static function boot()
    {
        parent::boot();


    }

    protected $fillable = [
        'phone',
        'verify',
        'bann',
        'user_id',
        'loged',
    ];


    public $timestamps = false;

    protected $table = 'phones';


    public function user()
    {
        return $this->belongsTo(User::class,'user_id' , 'id');
    }

}

<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;

class Lists extends Model
{


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
            Cache::forget('headerLists');
            Cache::forget('footerLists');

        });
        static::updating(function ($model){
            $model->updated_by = auth()->id();
            Cache::forget('headerLists');
            Cache::forget('footerLists');

        });
    }
//    public function getRouteKeyName()
//    {
//        return 'id';
//    }
//



    protected $casts = [
        'header'=> 'boolean',
        'footer'=> 'boolean',
    ];

    protected $fillable = [
        'name',
        'parent_id',
        'sort',
        'link',
        'icon',
        'dark_icon',
        'type',
        'header',
        'footer',
        'menu_type',
        'listable_id',
        'listable_type',
        'added_by',
        'updated_by',
    ];
    protected $menu_types = [
        'default'=>'پیش فرض',
        'megamenu'=>'مگا منو',
        'relate'=>'پیشرفته(مخصوص برگه و دسته)',
    ];



    public $timestamps = true;

    protected $table = 'list';


    public function listable()
    {
        return $this->morphTo();
    }


    public function child()
    {
        return $this->hasMany(Lists::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(Lists::class, 'id', 'parent_id');
    }



    public function added_by()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function updated_by()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }





    public function scopeWithUserData($query)
    {
        return BaseQuery::queryWithUserData($query,false);
    }

    public function makeLink()
    {

        if ($this->type == 'link'){
            return $this->link;
        }elseif ($this->type == 'page'){
            return route('page.show',['page'=>$this->listable_id]);
        }else{
            return $this->link;
        }
    }

    public function getMenuType()
    {
        return $this->menu_types[$this->menu_type];
    }
    public function haveLink()
    {
        return $this->type == 'link' && $this->link == null;
    }
    public function getMenuTypes()
    {
        return $this->menu_types;
    }


}

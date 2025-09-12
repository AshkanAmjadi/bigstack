<?php

namespace Modules\User\App\Models;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use App\facade\Module\ModuleFacade;
use App\Models\Answer;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Conversation;
use App\Models\Like;
use App\Models\Tact;
use App\Traits\HasLoginTracking;
use App\Traits\HasMorphAlias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Vinkla\Hashids\Facades\Hashids;

class User extends Authenticatable
{
    use HasFactory, Notifiable ,HasLoginTracking , HasMorphAlias ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public static string $morphClass;

    protected static function boot()
    {

        parent::boot();

        static::retrieved(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
        });
        static::creating(function ($model) {
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        static::created(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);


            $changes = collect($model->getAttributes())
                ->except(['id', 'created_at', 'updated_at']) // فیلدهای سیستمی حذف شن
                ->mapWithKeys(fn($value, $key) => [$key => ['old' => null, 'new' => $value]])
                ->toArray();

            ModuleFacade::logIfAvailable(
                subject: $model,
                event: 'created',
                description: 'new user created',
                properties: ['changes' => $changes],
                adminAsUser: true
            );



        });
        static::updating(function ($model) {
            $model->updated_by = auth()->id();
            unset($model->hash_id);
        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);

            $dirty = $model->getChanges();
            $original = $model->getOriginal();

            $excludeFields = ['updated_at','updated_by','news' , 'email_verify' , 'by_phone' ,'avatar' ];

            if (!empty($dirty)) {

                $changesFormatted = BaseMethod::changesWithHistory($dirty,$original,$excludeFields);


                ModuleFacade::logIfAvailable(
                    subject: $model,
                    event: 'updated',
                    description: 'edit user info',
                    properties: [
                        'changes' => $changesFormatted
                    ],
                    level: 'debug',
                    adminAsUser: true
                );

            }


        });

    }

    protected $fillable = [
        'name',
        'username',
        'username_set',
        'email',
        'melicode',
        'news',
        'avatar',
        'staff',
        'boss',
        'gender',
        'day',
        'about_me',
        'insta_id',
        'month',
        'year',
        'email_verify',
        'by_google',
        'by_phone',
        'status', //اضافه شد
        'added_by',
        'updated_by'
    ];



    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected array $status = [
         'active', 'inactive', 'quarantined', 'banned', 'pending_verification'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];


    public function is_staff()
    {
        return $this->staff;
    }
    public function is_boss()
    {
        return $this->boss;
    }
    public function is_superuser()
    {
        return $this->superuser;
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function mainPhone()
    {
        return $this->hasOne(Phone::class);
    }
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
    public function enters()
    {
        return $this->hasMany(comment::class);
    }
    public function allerts()
    {
        return $this->hasMany(UserAllert::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function tacts()
    {
        return $this->hasMany(Tact::class);
    }
    public function marks()
    {
        return $this->hasMany(Bookmark::class);
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function best_answers()
    {
        return $this->hasMany(Answer::class)->where('best' , '=',true);
    }


    public function hasRole($roles)
    {
        return !! $roles->intersect($this->roles)->all();
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('name' , $permission->name) || $this->hasRole($permission->getRelations()['roles']);
    }


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

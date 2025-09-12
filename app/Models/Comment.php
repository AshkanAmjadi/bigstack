<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use App\facade\Notification\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\App\Models\User;

class Comment extends Model
{


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
        static::created(function ($model) {
            $user = $model->user;
            $commentable = $model->commentable;
            $table = $commentable->getTable();
            $name_fa = BaseQuery::getPersionOfTable($table);
            $commentable_title =  $commentable->page_title;

            $data = [
                'first' => Str::limit($model->content, 30, '...'),
                'second' => htmlAlink(route('profile', ['username' => $user->username]), $user->name,true),
                'third' => $name_fa . htmlAlink(route("$table.show", [$table => $commentable->slug]), $commentable_title )
            ];
            if ($model->parent > 0) {
                $parentCommentUser = $model->parentComment->user;
                $parent = htmlAlink(route('profile', ['username' => $parentCommentUser->username]), $parentCommentUser->name,true);
                $data['first'] .= "Replying to: $parent";

            }
            Notification::admin('success', 'commentAdded', $data);
        });
        static::updated(function ($model) {
            $changes = $model->getChanges();
            $commentable = $model->commentable;
            $user = $model->user;
            $table = $commentable->getTable();
            $name_fa = BaseQuery::getPersionOfTable($table);
            $commentable_title =  $commentable->page_title;


            if (isset($changes['active'])) {

                if ($changes['active'] === true) {
                    $data = [
                        'first' => $name_fa,
                        'second' => htmlAlink(route("$table.show", [$table => $commentable->slug]), $commentable_title)
                    ];
                    Notification::user($model->user_id, 'success', 'verifyComment', $data);

                    if ($model->parent > 0) {
                        $parentCommentUser = $model->parentComment->user;

                        $data = [
                            'first' => $name_fa,
                            'second' => htmlAlink(route("$table.show", [$table => $commentable->slug]), $commentable_title),
                            'third' => htmlAlink(route('profile', ['username' => $user->username]), $user->name,true)
                        ];

                        Notification::user($parentCommentUser->id, 'success', 'answerToComment', $data);

                    }

                } else {
                    $data = [
                        'first' => $name_fa,
                        'second' => htmlAlink(route("$table.show", [$table => $commentable->slug]), $commentable_title)
                    ];

                    Notification::user($model->user_id, 'warning', 'commentDeactive', $data);
                }
            }
        });
        self::deleting(function ($model) {
            $model->likes()->delete();
        });
        self::deleted(function ($model) {
            $commentable = $model->commentable;
            $table = $commentable->getTable();
            $name_fa = BaseQuery::getPersionOfTable($table);

            $data = [
                'first' => $name_fa,
                'second' => htmlAlink(route("$table.show", [$table => $commentable->slug]), $commentable->page_title)
            ];

            Notification::user($model->user_id, 'danger', 'commentDeleted', $data);
        });

    }

    protected $casts = [
        'active' => 'bool',
    ];

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'title',
        'content',
        'parent',
        'new',
//        'positiveTint',
//        'negativeTint',
        'star',
        'active',
    ];


    public $timestamps = true;

    protected $table = 'comments';


    public function commentable()
    {
        return $this->morphTo();
    }

    public function liked()
    {
        return $this->morphMany(Like::class, 'like', 'likeable_type', 'likeable_id', 'id')->where('user_id', '=', auth()->id());
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'like', 'likeable_type', 'likeable_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(Comment::class, 'parent', 'id');
    }

    public function activeChild()
    {
        return BaseQuery::activeAndUserObjQuery($this->hasMany(Comment::class, 'parent', 'id'));
    }

    public function parentComment()
    {
        return $this->hasOne(Comment::class, 'id', 'parent');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

//    public function tacts()
//    {
//        return $this->morphMany(Tact::class, 'tacts','tactable_type','tactable_id','id');
//    }


}

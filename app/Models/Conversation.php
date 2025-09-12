<?php

namespace App\Models;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use App\facade\Module\ModuleFacade;
use App\facade\Notification\Notification;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;
use Modules\User\App\Models\User;

class Conversation extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model){

            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);

            if ($model->mention == null){
                $model->mention = [];
            }
        });
        static::creating(function ($model) {
            $model->user_id = auth()->id();
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();



        });
        static::created(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
            $user = $model->user;

            $data = [
                'first' =>  htmlAlink(route('conversation.show', ['conversation' => $model->slug]), $model->title),
                'second' => htmlAlink(route('profile', ['username' => $user->username]), $user->name,true),
            ];
            Notification::admin('info', 'conversationAdded', $data);
        });
        static::updating(function ($model) {
            BaseMethod::removeCacheDynamic($model,['tags','user','schema','mentions']);

            $model->updated_by = auth()->id();
            unset($model->hash_id);

        });
        static::updated(function ($model){
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);

            $changes = $model->getChanges();



            if (isset($changes['active'])) {

                if ($changes['active'] === true) {
                    $data = [
                        'first' =>  htmlAlink(route('conversation.show', ['conversation' => $model->slug]), $model->title),
                    ];

                    Notification::user($model->user_id, 'success', 'verifyConversation', $data);

                    if ($model->mention){

                        $creator = $model->user->username;

                        $mentions = $model->mention;


                        foreach ($mentions as $mention){

                            $mentionData = [
                                'first'=>'yout question',
                                'second'=>htmlAlink(route('profile', ['username' => $creator]), $creator . '@' ,true),
                                'third' => htmlAlink(route('conversation.show', ['conversation' => $model->slug]), $model->title)
                            ];
                            Notification::user($mention, 'info', 'mentionToUser',$mentionData );


                        }
                    }




                } else {
                    $data = [
                        'first' =>  htmlAlink(route('conversation.show', ['conversation' => $model->slug]), $model->title),
                    ];

                    Notification::user($model->user_id, 'warning', 'conversationDeactive', $data);
                }
            }
        });
        static::deleting(function ($model) {

            BaseMethod::removeCacheDynamic($model,['tags','user','schema','mentions']);

            $model->tags()->detach();
            $model->likes()->delete();
            $model->marks()->delete();
            $model->answers()->each(function ($ans) {
                $ans->delete();
            });

            ModuleFacade::logIfAvailable(
                subject: $model, level: 'notice', description: 'A conversation along with (likes, bookmarks, answers) was deleted', event: 'delete'
            );

        });
        self::deleted(function ($model) {

            if (auth()->id() != $model->user->id ){
                $data = [
                    'first' => $model->title,
                ];

                Notification::user($model->user_id, 'danger', 'conversationDeleted', $data);

            }


        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }




    protected $casts = [
        'mention' => 'array',
    ];


    protected $fillable = [
        'title',
        'slug',
        'description',
        'user_id',
        'active',
        'mention',
        'private',
        'new',
        'has_best',
        'view',
        'added_by',
        'updated_by',
    ];

    public $timestamps = true;


    protected $table = 'conversations';

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggable');
    }


    public function answers()
    {
        return $this->hasMany(Answer::class, 'conversation_id', 'id');
    }

    public function activeAnswers()
    {
        return $this->hasMany(Answer::class, 'conversation_id', 'id')->where('active', '=', true);
    }
    public function bestAnswer()
    {
        return $this->hasMany(Answer::class, 'conversation_id', 'id')->where('best', '=', true)->with([
            'user' => function ($query) {
                $query->select(['id', 'name', 'avatar','username','updated_at']);
            },
            'tacts'
        ])->first();
    }

    public function MyAnswers()
    {
        return $this->hasMany(Answer::class, 'conversation_id', 'id')->where('user_id', '=', auth()->id());
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function marks()
    {
        return $this->morphMany(Bookmark::class, 'mark', 'markable_type', 'markable_id', 'id');
    }

    public function marked()
    {
        return $this->morphMany(Bookmark::class, 'mark', 'markable_type', 'markable_id', 'id')->where('user_id', '=', auth()->id());
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'like', 'likeable_type', 'likeable_id', 'id');
    }

    public function liked()
    {
        return $this->morphMany(Like::class, 'like', 'likeable_type', 'likeable_id', 'id')->where('user_id', '=', auth()->id());
    }

    public function added_by()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function updated_by()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }


    public function scopeWithUserData($query, $trashed = false)
    {
        return BaseQuery::queryWithUserData($query, $trashed);
    }
}

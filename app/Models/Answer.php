<?php

namespace App\Models;

use App\facade\BaseQuery\BaseQuery;
use App\facade\Notification\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Modules\User\App\Models\User;
use Vinkla\Hashids\Facades\Hashids;

class Answer extends Model
{



    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);

            if ($model->mention == null){
                $model->mention = [];
            }
        });
        static::creating(function ($model) {
            Cache::forget('conversations' . $model->conversation_id . 'schema');
            $model->user_id = auth()->id();
            $model->added_by = auth()->id();
            $model->updated_by = auth()->id();
        });
        static::created(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);
            $user = $model->user;
            $conversation = $model->conversation;

            $data = [
                'first' => htmlAlink(route('conversation.show', ['conversation' => $conversation->slug,'toAnswer' => $model->hash_id]). '#' .$model->hash_id, $conversation->title, $conversation->title),
                'second' => htmlAlink(route('profile', ['username' => $user->username]), $user->name, true),
            ];
            Notification::admin('success', 'answerAdded', $data);
        });
        static::updating(function ($model) {
            Cache::forget('conversations' . $model->conversation_id . 'schema');
            $model->updated_by = auth()->id();
            unset($model->hash_id);

        });
        static::updated(function ($model) {
            $model->hash_id = Hashids::connection($model->getTable())->encode($model->id);

            $user = $model->user;
            $changes = $model->getChanges();
            $conversation = $model->conversation;


            if (isset($changes['active'])) {

                if ($changes['active'] === true) {
                    $data = [
                        'first' => htmlAlink(route('conversation.show', ['conversation' => $conversation->slug,'toAnswer' => $model->hash_id]) . '#' .$model->hash_id, $conversation->title),
                    ];
                    $data2 = [
                        'second' => htmlAlink(route('conversation.show', ['conversation' => $conversation->slug,'toAnswer' => $model->hash_id]) . '#' .$model->hash_id, $conversation->title),
                        'first' => htmlAlink(route('profile', ['username' => $user->username]), $user->name, true),
                    ];
                    Notification::user($model->user_id, 'success', 'verifyAnswer', $data);
                    Notification::user($conversation->user_id, 'success', 'answerToConversation', $data2);
                    if ($model->mention){

                        $creator = $model->user->username;

                        $mentions = User::query()->whereIn('username',$model->mention )->get('id');

                        foreach ($mentions as $mention){

                            $mentionData = [
                                'first' => 'Your answer to the question',
                                'second'=>htmlAlink(route('profile', ['username' => $creator]), $creator . '@' ,true),
                                'third' => htmlAlink(route('conversation.show',['conversation'=>$conversation->slug,'toAnswer' => $model->hash_id]) . '#' .$model->hash_id, $conversation->title)
                            ];

                            Notification::user($mention->id, 'info', 'mentionToUser',$mentionData );


                        }
                    }


                } else {
                    $data = [
                        'first' => htmlAlink(route('conversation.show', ['conversation' => $conversation->slug]), $conversation->title),
                    ];

                    Notification::user($model->user_id, 'warning', 'answerDeactive', $data);
                }
            }
        });
        self::deleting(function ($model) {
            Cache::forget('conversations' . $model->conversation_id . 'schema');
            if ($model->best) {
                $model->conversation()->update(['has_best' => false]);
            }
            $model->tacts()->delete();
        });
        self::deleted(function ($model) {


            if (auth()->id() != $model->user->id) {
                $conversation = $model->conversation;

                $data = [
                    'first' => htmlAlink(route('conversation.show', ['conversation' => $conversation->slug]), $conversation->title),
                ];

                Notification::user($model->user_id, 'danger', 'answerDeleted', $data);

            }


        });

    }

    protected $casts = [
        'active' => 'bool',
        'best' => 'bool',
        'new' => 'bool',
        'mention' => 'array',
    ];

    protected $fillable = [
        'title',
        'user_id',
        'conversation_id',
        'active',
        'content',
        'mention',
        'new',
        'best',
        'added_by',
        'updated_by',
    ];


    public $timestamps = true;

    protected $table = 'answer';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function added_by()
    {
        return $this->hasOne(User::class, 'id', 'added_by');
    }

    public function updated_by()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function tacts()
    {
        return $this->morphMany(Tact::class, 'tacts', 'tactable_type', 'tactable_id', 'id')->where('tact_type', '=', 'tact');
    }

    public function upVote()
    {
        return $this->morphMany(Tact::class, 'tacts', 'tactable_type', 'tactable_id', 'id')->where('tact_type', '=', 'tact')->where('tact_value', '=', true);
    }

    public function downVote()
    {
        return $this->morphMany(Tact::class, 'tacts', 'tactable_type', 'tactable_id', 'id')->where('tact_type', '=', 'tact')->where('tact_value', '=', false);
    }


    public function scopeWithUserData($query, $trashed = false)
    {
        return BaseQuery::queryWithUserData($query, $trashed);
    }


}

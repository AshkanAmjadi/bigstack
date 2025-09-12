<?php

namespace App\Livewire\Comment;

use App\facade\BaseQuery\BaseQuery;
use App\Models\Comment;
use Livewire\Attributes\Locked;
use Livewire\Component;

class MoreComments extends Component
{
    #[Locked]
    public $count;
    #[Locked]
    public $parent;
    #[Locked]
    public $show = false;

    public function mount($parent,$count)
    {
        $this->parent = $parent;
        $this->count = $count;
    }
    public function showComment()
    {
        $this->show = true;
    }
    public function render()
    {
        if ($this->show){
            $comments = Comment::query()->latest()->where(['parent'=>$this->parent]);

            $comments = $comments->with([
                'user' => function ($query){
                    $query->select(['id','name','avatar','updated_at','username']);
                },
            ])->withCount('activeChild as child_count');
            $comments = BaseQuery::cardSubjectNeed($comments,['like']);
            $comments = BaseQuery::activeAndUserObjQuery($comments)->get();
        }else{
            $comments = [];
        }

        return view('livewire.comment.more-comments',['comments' => $comments]);
    }
}

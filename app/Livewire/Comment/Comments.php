<?php

namespace App\Livewire\Comment;


use App\facade\BaseQuery\BaseQuery;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination,WithoutUrlPagination;
    #[Locked]
    public $subjectId;
    #[Locked]
    public $model;
    #[Locked]
    public $type;
    #[Locked]
    public $show = false;

    public function mount($subject,$model = 'Article',$name = 'مقاله')
    {

        if ($model == 'Article') {
            $this->model ='Modules\Content\App\Models\\'. $model;

        }else{
            $this->model ='App\Models\\'. $model;

        }
        $this->subjectId = $subject;
        $this->type = $model;

    }
    public function refresh()
    {
        $this->dispatch('toComments')->self();

    }
    public function goToPage($page)
    {


        $val = Validator::make([
            'page' => $page
        ],[
            'page' => 'required|integer|min:1|max:999999999'
        ]);

        if ($val->fails()){
            abort(500);
        }

        $this->setPage($page);
        $this->dispatch('toComments')->self();


    }

    #[On('comment_deleted')]
    public function deleteComment()
    {

    }



    public function start()
    {

        $this->show = true;

    }
    public function render()
    {

        if (!in_array($this->type,modelCanCall())){
            abort(500);
        }

        if ($this->show){
            $comments = $this->model::query()->findOrFail($this->subjectId)->comments()->latest()->where(['parent'=>0]);


            $comments = $comments->with([
                'user' => function ($query){
                    $query->select(['id','name','avatar','updated_at','username']);
                },
                'child'=> function ($query){
                    $query =  BaseQuery::activeAndUserObjQuery($query)->with([
                        'user' => function ($query){
                            $query->select(['id','name','avatar','updated_at','username']);
                        },
                    ])->withCount('activeChild as child_count');

                    BaseQuery::cardSubjectNeed($query,['like']);

                }
            ]);
            $comments = BaseQuery::cardSubjectNeed($comments,['like']);
            $comments = BaseQuery::activeAndUserObjQuery($comments)->paginate(2);

        }else{
            $comments = [];
        }


        return view('livewire.comment.comments',['comments' => $comments]);
    }
}

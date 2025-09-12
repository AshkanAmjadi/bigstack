<?php

namespace Modules\User\App\Livewire\Profile;



use App\facade\BaseQuery\BaseQuery;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Tacts extends Component
{
    use WithPagination;

    public $subject = 'article';
    public $type = 'bookmark';

    #[Locked]
    public $subjects = [
        'article' => 'Articles',
        'discuss' => 'Questions',
        'comment' => 'Comments',
        'project' => 'Projects',
        'answer' => 'Answers',
    ];
    #[Locked]
    public $likeSub = [
        'article' => 'Articles',
        'discuss' => 'Discuss',
        'comment' => 'Comments',
        'project' => 'Projects',
    ];
    #[Locked]
    public $markSub = [
        'article' => 'Articles',
        'discuss' => 'Discuss',
        'project' => 'Projects',
    ];
    #[Locked]
    public $starSub = [
        'article' => 'Articles',
        'project' => 'Projects',
    ];
    #[Locked]
    protected $queryString = [
        'type' => ['except' => 'bookmark'],
        'subject' => ['except' => 'article'],
    ];
    #[Locked]
    public $types = [
        'bookmark' => 'Marks',
        'star' => 'Rates',
        'like' => 'Likes',
        'usefull' => 'Votes'
    ];
    #[Locked]
    public $relations = [
        'bookmark' => 'markable',
        'star' => 'tactable',
        'like' => 'likeable',
        'usefull' => 'tactable'
    ];

    public function mount()
    {

        if (!isset($this->types[$this->type])) {
            abort(500);
        }
        if (!isset($this->subjects[$this->subject])) {
            abort(500);
        }

    }

    public function setType($type)
    {

        if (!isset($this->types[$type])) {
            abort(500);
        }

        $this->setPage(1);
        $this->type = $type;

        if ($type == 'usefull'){
            $this->subject = 'answer';
        }elseif ($type == 'star'){
            $this->subject = 'article';
        }else{
            if ($this->subject == 'answer' or $this->subject == 'comment'){
                $this->subject = 'article';
            }
        }

        $this->dispatch('toArticles');

    }
    public function goToPage($page)
    {

        $val = Validator::make([
            'page' => $page
        ], [
            'page' => 'required|integer|min:1|max:999999999'
        ]);

        if ($val->fails()) {
            abort(500);
        }

        $this->setPage($page);
        $this->dispatch('toArticles');

    }

    public function goToSubject($subject)
    {

        if (!isset($this->subjects[$subject])) {
            abort(500);
        }
        $this->setPage(1);
        $this->subject = $subject;
        $this->dispatch('toArticles');

    }


    public function render()
    {
        $items = [];
        if ($this->type == 'like') {
            if ($this->subject == 'article'){
                $items = auth()->user()
                    ->likes()->orderBy('id','desc')
                    ->where('likeable_type', '=', 'art')->with([
                        'likeable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['liked']);
                        }
                    ]);

            }elseif ($this->subject == 'discuss'){
                $items = auth()->user()
                    ->likes()->orderBy('id','desc')
                    ->where('likeable_type', '=', 'conver')->with([
                        'likeable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['liked','user']);
                        }
                    ]);

            }elseif ($this->subject == 'project'){
                $items = auth()->user()
                    ->likes()->orderBy('id','desc')
                    ->where('likeable_type', '=', 'prj')->with([
                        'likeable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['liked']);
                        }
                    ]);

            }elseif ($this->subject == 'comment'){
                $items = auth()->user()
                    ->likes()->orderBy('id','desc')
                    ->where('likeable_type', '=', 'comm')->with([
                        'likeable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['liked','user']);
                            $q->with('commentable');
                        }
                    ]);
            }
        }
        elseif ($this->type == 'bookmark'){
            if ($this->subject == 'article'){
                $items = auth()->user()
                    ->marks()->orderBy('id','desc')
                    ->where('markable_type', '=', 'art')->with([
                        'markable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['marked']);
                        }
                    ]);

            }elseif ($this->subject == 'project'){
                $items = auth()->user()
                    ->marks()->orderBy('id','desc')
                    ->where('markable_type', '=', 'prj')->with([
                        'markable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['marked']);
                        }
                    ]);

            }elseif ($this->subject == 'discuss'){
                $items = auth()->user()
                    ->marks()->orderBy('id','desc')
                    ->where('markable_type', '=', 'conver')->with([
                        'markable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['marked','user']);
                        }
                    ]);

            }
        }
        elseif ($this->type == 'star'){
            if ($this->subject == 'article'){
                $items = auth()->user()
                    ->tacts()->orderBy('id','desc')
                    ->where('tactable_type', '=', 'art')
                    ->where('tact_type', '=', 'star')
                    ->with([
                        'tactable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['star']);
                        }
                    ]);

            }elseif ($this->subject == 'project'){
                $items = auth()->user()
                    ->tacts()->orderBy('id','desc')
                    ->where('tactable_type', '=', 'prj')
                    ->where('tact_type', '=', 'star')
                    ->with([
                        'tactable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['star']);
                        }
                    ]);

            }
        }
        elseif ($this->type == 'usefull'){
            if ($this->subject == 'answer'){
                $items = auth()->user()
                    ->tacts()->orderBy('id','desc')
                    ->where(['tactable_type'=> 'ans','tact_type' => 'tact','tact_value' => true])
                    ->with([
                        'tactable' => function($q){
                            $q = BaseQuery::cardSubjectNeed($q, ['user']);
                            $q->with([
                                'conversation' => function($q){
                                $q->select(['id','slug','title']);
                                }
                            ]);
                        }
                    ]);

            }
        }

        if ($items !== []){
            $items = $items->paginate(10);
        }

        return view('user::livewire.profile.tacts',compact('items'));
    }
}

<?php

namespace App\Livewire\Tag;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{

    use WithPagination;

    public $subject = 'article';
    public $type = 'new';
    public $discuss_type = 'new';
    public $time = 'null';
    public $filter = 'all';
    #[Locked]
    public $subjects;



    #[Locked]
    public $types;
    #[Locked]
    public $discuss_types;
    #[Locked]
    public $times;
    #[Locked]
    public $filters;
    #[Locked]
    public $tag;
    #[Locked]
    protected $queryString = [
        'subject' => ['except' => 'article'],
        'type' => ['except' => 'new'],
        'discuss_type' => ['except' => 'new'],
        'time' => ['except' => 'null'],
        'filter' => ['except' => 'all'],
    ];

    public function mount($tag)
    {

        $this->subjects = BaseCat::getSearchCases('tag');


        $this->tag = $tag;
        $this->times = BaseCat::getFilters('times');
        $this->types = BaseCat::getFilters('types');
        $this->discuss_types = BaseCat::getFilters('types_con');
        $this->filters = BaseCat::getFilters('filter_con');


        if (!isset($this->types[$this->type])) {
            abort(500);
        }
        if (!isset($this->times[$this->time])) {
            abort(500);
        }
        if (!isset($this->filters[$this->filter])) {
            abort(500);
        }
        if (!isset($this->discuss_types[$this->discuss_type])) {
            abort(500);
        }
        if (!isset($this->subjects[$this->subject])) {
            abort(500);
        }


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

        $this->type = 'new';
        $this->discuss_type = 'new';
        $this->filter = 'all';
        $this->time = 'null';
        $this->subject = $subject;
        $this->dispatch('toArticles');

    }


    public function setType($type)
    {

        if (!isset($this->types[$type])) {
            abort(500);
        }

        $this->type = $type;
        $this->dispatch('toArticles');

    }

    public function setTime($time)
    {

        if (!isset($this->times[$time])) {
            abort(500);
        }

        $this->time = $time;
        $this->dispatch('toArticles');

    }
    public function refresh()
    {

    }


    public function setFilter($filter)
    {

        if (!isset($this->filters[$filter])) {
            abort(500);
        }

        $this->filter = $filter;
        $this->dispatch('toArticles');

    }
    public function setDiscussType($discuss_type)
    {

        if (!isset($this->discuss_types[$discuss_type])) {
            abort(500);
        }

        $this->discuss_type = $discuss_type;
        $this->dispatch('toArticles');

    }
    public function render()
    {

        $tag = Cache::rememberForever('tag.'.$this->tag,function (){
            return Tag::query()->where('name','=',$this->tag)->firstOrFail();
        });


        if ($this->subject == 'article'){
            $items =  BaseQuery::activeQuery($tag->article());
            $items = BaseQuery::filterQuery($items, $this->time, $this->type);
            $items = BaseQuery::cardSubjectNeed($items, ['cat', 'mark', 'star', 'like']);

        }elseif ($this->subject == 'discuss'){

            $items =  BaseQuery::activeQuery($tag->conversation())->with([
                'user' => function ($query) {
                    $query->select(['id', 'name', 'avatar','updated_at','username']);
                },
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },

            ])
                ->withCount('activeAnswers');;
            $items = BaseQuery::filterQuery($items, $this->time, $this->discuss_type,$this->filter);
            $items = BaseQuery::cardSubjectNeed($items, ['mark', 'like']);

        }elseif ($this->subject == 'project'){
            $items =  BaseQuery::activeQuery($tag->project()->with([
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },
            ]));
            $items = BaseQuery::filterQuery($items, $this->time, $this->type);
            $items = BaseQuery::cardSubjectNeed($items, ['mark', 'star', 'like','service']);
        }

        $items = $items->paginate(8);


        return view('livewire.tag.search',['items'=>$items,'tagObj'=>$tag]);
    }
}

<?php

namespace App\Livewire\Conversation;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use App\facade\BaseValidation\BaseValidation;
use App\Models\Conversation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $type = 'new';
    public $time = 'null';
    public $filter = 'all';
    public $search;
    public $tags = [];



    #[Locked]
    public $types;
    #[Locked]
    public $times;
    #[Locked]
    public $filters;
    #[Locked]
    public $searchError = [];
    #[Locked]
    public $errors = [];

    #[Locked]
    protected $queryString = [
        'tags' => ['except' => null],
        'search' => ['except' => ''],
        'type' => ['except' => 'new'],
        'time' => ['except' => 'null'],
        'filter' => ['except' => 'all'],
    ];


    public function mount()
    {


        $this->times = BaseCat::getFilters('times');
        $this->types = BaseCat::getFilters('types_con');
        $this->filters = BaseCat::getFilters('filter_con');

        //protect from user first query string reading

        if (!isset($this->types[$this->type])) {
            abort(500);
        }
        if (!isset($this->times[$this->time])) {
            abort(500);
        }
        if (!isset($this->filters[$this->filter])) {
            abort(500);
        }

        $val = Validator::make(['tags' => $this->tags, 'search' => $this->search],
            [
                'tags' => [
                    'array'
                ],
                'tags.*' => ['required', 'string', 'exists:tag,name'],
                'search' => [
                    'string',
                    'nullable',
                    'max:250',
                ],
            ]);

        if ($val->fails()) {
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


    public function tagFilter($checked, $tag)
    {


        $val = Validator::make([
            'checked' => $checked
        ], [
            'checked' => 'required|boolean',
        ]);

        if ($val->fails()) {
            abort(500);
        }

        if ($checked) {
            array_push($this->tags, $tag);
        } else {

            foreach ($this->tags as $key => $value) {
                if ($value == $tag) {
                    unset($this->tags[$key]);
                }
            }

        }
        //tags Validation

        $val = Validator::make(['tags' => $this->tags],
            [
                'tags' => [
                    'array'
                ],
                'tags.*' => ['required', 'string', 'exists:tag,name'],
            ]);

        if ($val->fails()) {
            abort(500);
        }

    }

    public function setType($type)
    {


        if (!isset($this->types[$type])) {
            abort(500);
        }

        $this->type = $type;
        $this->dispatch('toArticles');

    }

    public function setSearch($search)
    {

        $val = Validator::make(['search' => $search],
            [
                'search' => [
                    'string',
                    'nullable',
                    'min:3',
                    'max:250',
                ]

            ], [
                'search.min' => 'At least 3 characters are required to search.',
            ]);

        if ($val->fails()) {
            $this->searchError = $val->errors()->toArray()['search'];
        } else {
            $this->searchError = [];

        }
        $this->search = clean($search);


    }

    public function setTime($time)
    {
        if (!isset($this->times[$time])) {
            abort(500);
        }

        $this->time = $time;
        $this->dispatch('toArticles');

    }

    public function setFilter($filter)
    {

        if (!isset($this->filters[$filter])) {
            abort(500);
        }

        $this->filter = $filter;
        $this->dispatch('toArticles');

    }

    public function refresh()
    {

        $this->dispatch('toArticles');

    }

    public function render()
    {


        $items = Conversation::query()
            ->with([
                'user' => function ($query) {
                    $query->select(['id', 'name', 'avatar','updated_at','username']);
                },
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },

            ])
            ->withCount('activeAnswers');


        if ($this->search and empty($this->searchError)) {
            $items = $items->where('title', 'LIKE', "%" . $this->search . "%");
        }
        $items = BaseQuery::cardSubjectNeed($items, ['mark', 'like']);
        $items = BaseQuery::filterQuery($items, $this->time, $this->type, $this->filter);
        $items = BaseQuery::privateAndUserObjQuery($items);
        $items = BaseQuery::activeAndUserObjQuery($items);
        if (!empty($this->tags)) {
            $items = BaseQuery::tagFilter($items, $this->tags);
        }
        $items = $items->paginate(6);

        return view('livewire.conversation.search', ['items' => $items]);
    }
}

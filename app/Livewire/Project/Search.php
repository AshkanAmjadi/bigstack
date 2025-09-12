<?php

namespace App\Livewire\Project;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use App\Models\Conversation;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{


    use WithPagination;

    public $type = 'new';
    public $time = 'null';
    public $service = null;
    public $search;
    public $tags = [];


    #[Locked]
    public $types;
    #[Locked]
    public $times;

    #[Locked]
    public $services;

    #[Locked]
    public $searchError = [];
    #[Locked]
    public $errors = [];

    #[Locked]
    protected $queryString = [
        'service' => ['except' => null],
        'tags' => ['except' => null],
        'search' => ['except' => null],
        'type' => ['except' => 'new'],
        'time' => ['except' => 'null'],
    ];


    public function mount()
    {


        $this->services = BaseCat::getAllService();

        $this->times = BaseCat::getFilters('times');
        $this->types = BaseCat::getFilters('types');


        //protect from user first query string reading


        if (!isset($this->types[$this->type])) {
            abort(500);
        }
        if (!isset($this->times[$this->time])) {
            abort(500);
        }
        if (!$this->service){
            if (!$this->services->where(['name',$this->service])->first()) {
                abort(500);
            }
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

    }
    public function setService($service)
    {


        if (!$this->services->where('name',$service)->first()) {
            abort(500);
        }

        $this->service = $service;

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
                'search.min' => 'At least 3 characters are required for search',

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

    }


    public function refresh()
    {

        $this->dispatch('toArticles');

    }

    public function render()
    {

        if ($this->service){
            $items = Service::query()->where('name','=',$this->service)->first(['id','name'])->project();
        }else{
            $items = Project::query();
        }

        $items = $items
            ->with([
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },

            ]);

        if ($this->search and empty($this->searchError)) {
            $items = $items->where('title', 'LIKE', "%" . $this->search . "%");
        }
        $items = BaseQuery::cardSubjectNeed($items, ['mark', 'like', 'star','service']);
        $items = BaseQuery::filterQuery($items, $this->time, $this->type);
        $items = BaseQuery::activeQuery($items);
        if (!empty($this->tags)) {
            $items = BaseQuery::tagFilter($items, $this->tags);
        }
        $items = $items->paginate(4);

        return view('livewire.project.search', ['items' => $items]);
    }

}

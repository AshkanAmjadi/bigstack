<?php

namespace App\Livewire\Home;

use App\facade\BaseQuery\BaseQuery;
use Modules\Content\App\Models\Article;
use App\Models\Conversation;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;
use function PHPUnit\Framework\isNull;

class Search extends Component
{

    public $subject = 'article';
    public $search;



    public $show = false;
    #[Locked]
    public $subjects = [
        'article' => 'Articles',
        'project' => 'Projects',
        'tag' => 'Tags',
        'discuss' => 'Discuss'
    ];
    #[Locked]
    public $searchError = [];


    public function mount()
    {


    }

    public function goToSubject($subject,$search)
    {

        if (!isset($this->subjects[$subject])) {
            abort(500);
        }
        $val = Validator::make(['search' => $search],
            [
                'search' => [
                    'string',
                    'nullable',
                    'min:3',
                    'max:250',
                ]

            ], [
                'search.min' => 'At least 3 characters are required to search',
            ]);


        if ($val->fails()) {
            $this->searchError = $val->errors()->toArray()['search'];
        } else {
            $this->searchError = [];
        }

        $this->search = clean($search);
        $this->subject = $subject;
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
                'search.min' => 'At least 3 characters are required to search',
            ]);

        if ($val->fails()) {
            $this->searchError = $val->errors()->toArray()['search'];
        } else {
            $this->searchError = [];
        }
        $this->search = clean($search);
    }

    public function render()
    {


        $this->show = $this->search ? $this->show = Str::length($this->search) >= 3 : false;


        $items = [];
        if ($this->show) {
            if ($this->subject == 'article') {
                $items = Article::query()
                    ->where('title', 'like', "%{$this->search}%")
                    ->with([
                        'cat' => function ($query) {
                        $query->select(['id', 'title','slug']);
                        }
                    ])
                    ->orderBy('updated_at', 'desc')
                    ->limit(6)
                    ->get(['id', 'title', 'updated_at', 'img', 'category','slug'])
                    ->map(function ($items) {
                        $items->cat_name = $items->cat->title;
                        $items->cat_slug = $items->cat->slug;

                    return $items;
                });

            } elseif ($this->subject == 'tag') {
                $items = Tag::query()
                    ->where('name', 'like', "%{$this->search}%")
                    ->orderBy('updated_at', 'desc')
                    ->limit(6)
                    ->get(['id', 'name', 'updated_at']);

            } elseif ($this->subject == 'project') {
                $items = Project::query()
                    ->where('title', 'like', "%{$this->search}%")
                    ->with([
                        'service' => function ($query) {
                            $query->select(['id', 'name']);
                        }
                    ])
                    ->orderBy('updated_at', 'desc')
                    ->limit(6)
                    ->get(['id', 'title', 'updated_at', 'img', 'service_id','slug'])
                    ->map(function ($items) {
                        $items->srvc_name = $items->service->name;

                        return $items;
                    });

            } elseif ($this->subject == 'discuss') {
                $items = Conversation::query()
                    ->where('title', 'like', "%{$this->search}%")
                    ->with([
                        'user' => function ($query) {
                            $query->select(['id', 'name','avatar','updated_at','username']);
                        }
                    ])
                    ->orderBy('updated_at', 'desc')
                    ->limit(6)
                    ->get(['id', 'title','slug', 'updated_at','created_at','user_id']);
            }

        }


        return view('livewire.home.search', compact('items'));
    }
}

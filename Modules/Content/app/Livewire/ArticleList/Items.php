<?php

namespace Modules\Content\App\Livewire\ArticleList;

use App\facade\BaseCat\BaseCat;
use App\facade\BaseQuery\BaseQuery;
use Modules\Content\App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{

    use WithPagination;


    public $type = 'new';
    public $time = 'null';


    #[Locked]
    public $types;
    #[Locked]
    public $times;
    #[Locked]
    protected $queryString = [
        'type' => ['except' => 'new'],
        'time' => ['except' => 'null'],
    ];
    #[Locked]
    public $articleIds;
    #[Locked]
    public $childs;

    public function mount($articleIds)
    {
        $this->times = BaseCat::getFilters('times');
        $this->types = BaseCat::getFilters('types');

        //protect from user first query string reading
        if (!isset($this->types[$this->type])) {
            abort(500);
        }
        if (!isset($this->times[$this->time])) {
            abort(500);
        }

        $this->articleIds = $articleIds;
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

        $this->dispatch('toArticles');

    }

    public function setType($type)
    {


        if (!isset($this->types[$type])){
            abort(500);
        }

        $this->type = $type;
        $this->dispatch('toArticles');

    }

    public function setTime($time)
    {

        if (!isset($this->times[$time])){
            abort(500);
        }

        $this->time = $time;
        $this->dispatch('toArticles');

    }

    public function render()
    {

        $items = Article::query()->whereIn('id', $this->articleIds)->select(['id','page_title','meta_description','title','slug','alt','updated_at','level','category','active','img']);
        $items = BaseQuery::activeQuery($items);
        $items = BaseQuery::filterQuery($items, $this->time, $this->type);
        $items = BaseQuery::cardSubjectNeed($items, ['cat', 'mark', 'star', 'like'])->paginate(8);

        return view('content::livewire.article-list.items', compact('items'));
    }
}

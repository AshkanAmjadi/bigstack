<?php

namespace Modules\User\App\Livewire\Profile;



use App\facade\BaseQuery\BaseQuery;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Conversations extends Component
{

    use WithPagination;

    public $type = 'discuss';


    #[Locked]
    public $types = [
        'discuss' => 'Questions',
        'answer' => 'Answers',
    ];
    #[Locked]
    protected $queryString = [
        'type' => ['except' => 'discuss'],
    ];
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
        $this->dispatch('toTitle', el: 'ConAnsList');

    }
    public function setType($type)
    {
        if (!isset($this->types[$type])) {
            abort(500);
        }
        $this->setPage(1);
        $this->type = $type;
        $this->dispatch('toTitle', el: 'ConAnsList');


    }

    protected $listeners = ['AnsDeleted' => '$refresh'];

    #[On('ConDeleted')]
    public function refresh()
    {




    }

    public function render()
    {

        if ($this->type == 'discuss'){
            $items = auth()->user()->conversations()->withCount('activeAnswers')->orderBy('id','desc');
        }elseif ($this->type == 'answer'){
            $items = auth()->user()->answers()->with('conversation')->orderBy('id','desc');
        }
        $items = $items->paginate(10);



        return view('user::livewire.profile.conversations',compact('items'));
    }
}

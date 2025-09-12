<?php

namespace App\Livewire\Conversation;

use App\facade\BaseQuery\BaseQuery;
use App\Models\Answer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Answers extends Component
{

    use WithPagination;

    #[Locked]
    public $conversation;



    public function mount($conversation,$mentionToAnswer = null)
    {

        $this->conversation = $conversation;

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
        $this->dispatch('toAnswers')->self();
    }

    public function refresh()
    {
        $this->dispatch('toAnswers')->self();

    }

    #[On('answer_deleted')]
    public function deleteAnswer()
    {

    }


    public function render()
    {


        if ($this->conversation->firstAnswers){

            $answers = $this->conversation->firstAnswers;

        }else{
            $answers = $this->conversation->answers()->with([
                'user' => function ($query) {
                    $query->select(['id', 'name', 'avatar','updated_at','username']);
                },
                'tacts'
            ]);

            $answers = BaseQuery::activeAndUserObjQuery($answers)->paginate(30);
        }


        return view('livewire.conversation.answers', [
            'answers' => $answers,
        ]);
    }
}

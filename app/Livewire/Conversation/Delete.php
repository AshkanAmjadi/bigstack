<?php

namespace App\Livewire\Conversation;

use Livewire\Attributes\Locked;
use Livewire\Component;

class Delete extends Component
{
    #[Locked]
    public $model = "App\Models\\";
    #[Locked]
    public $id ;
    #[Locked]
    public $name ;
    #[Locked]
    public $type ;


    public function mount($id,$type,$name)
    {

        $this->model = $this->model. $type;
    }

    public function delete()
    {


        if (!in_array($this->type,modelCanCall())){
            abort(500);
        }

        $obj = $this->model::query()->findOrFail($this->id);

        if ($obj->user_id == auth()->id() or super()){
            if ($obj->user_id == auth()->id() and !$obj->active or super()){

                $obj->delete();
                $this->dispatch('toast', title: $this->name . ' has been deleted', type: 'success');

                if ($this->type == 'Conversation'){

                    $this->redirectRoute('discuss.search');

                }
                if ($this->type == 'Answer'){

                    $this->dispatch('answer_deleted');
                }
            }else{
                $this->dispatch('toast', title: $this->name . ' is approved and cannot be deleted', type: 'error');
            }
        }else{
            $this->dispatch('toast', title: 'You cannot delete this ' . $this->name, type: 'error');

        }


    }

    public function render()
    {
        return view('livewire.conversation.delete');
    }
}

<?php

namespace Modules\User\App\Livewire\Profile;


use App\facade\Module\ModuleFacade;
use Livewire\Attributes\Locked;
use Livewire\Component;

class DeleteCon extends Component
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

        $obj = $this->model::query()->find($this->id);


        if ($obj->user_id == auth()->id() || super()) {
            if ($obj->user_id == auth()->id() && !$obj->active || super()) {

                $obj->delete();
                $this->dispatch('toast', title: $this->name . ' has been deleted', type: 'success');
                $this->dispatch('toTitle', el: 'ConAnsList');
                $this->dispatch('ConDeleted');

            } else {
                $this->dispatch('toast', title: $this->name . ' is verified and cannot be deleted', type: 'error');
            }
        } else {
            $this->dispatch('toast', title: 'You cannot delete this ' . $this->name, type: 'error');
        }



    }
    public function render()
    {
        return view('user::livewire.profile.delete-con');
    }
}

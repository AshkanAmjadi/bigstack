<?php

namespace App\Livewire\Admin\List;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class MenuType extends Component
{
    #[Locked]
    public $list;

    public function mount($list)
    {
        $this->list = $list;
    }




    public function setType($type)
    {

        $val = Validator::make([
            'type' => $type
        ],[
            'type' => [
                'required',
                Rule::in('default', 'megamenu', 'relate')
            ]
        ]);

        if ($val->fails()){
            $this->dispatch('toast' ,title : 'تغییر نکرد' , type : 'error')->self();

        }else{
            $this->list->update(['menu_type' => $type]);
            $this->dispatch('toast' ,title : 'تغییر کرد' , type : 'success')->self();
        }


    }
    public function render()
    {
        return view('livewire.admin.list.menu-type');
    }
}

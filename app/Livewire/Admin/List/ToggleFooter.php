<?php

namespace App\Livewire\Admin\List;

use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ToggleFooter extends Component
{

    #[Locked]
    public $list;
    #[Locked]
    public $name = 'نمایش در فوتر';
    #[Locked]
    public $checked;

    public function mount($list)
    {
        $this->list = $list;
        $this->checked = $list->footer;
    }

    protected $rules = [
        'checked' => 'required|boolean',
    ];


    public function toggle($bool)
    {
        $this->checked = $bool;

        $val = Validator::make([
            'checked' => $this->checked
        ],$this->rules);

        if ($val->fails()){
            $this->dispatch('toast' ,title : 'تغییر نکرد' , type : 'error')->self();

        }else{
            $this->list->update(['footer' => $bool]);
            $this->dispatch('toast' ,title : 'تغییر کرد' , type : 'success')->self();
        }




    }

    public function render()
    {
        return view('livewire.admin.list.toggle-footer');
    }
}

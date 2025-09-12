<?php

namespace App\Livewire\Admin\List;

use App\Models\Lists;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ToggleHeader extends Component
{
    #[Locked]
    public $list;
    #[Locked]
    public $name = 'نمایش در هدر';
    #[Locked]
    public $checked;

    public function mount($list)
    {
        $this->list = $list;
        $this->checked = $list->header;
    }

    protected $rules = [
        'checked' => 'required|boolean',
    ];

    protected $messages = [
        'checked' => 'Something went wrong',
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
            $this->list->update(['header' => $bool]);
            $this->dispatch('toast' ,title : 'تغییر کرد' , type : 'success')->self();
        }




    }

    public function render()
    {
        return view('livewire.admin.list.toggle-header');
    }
}

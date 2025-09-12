<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Active extends Component
{

    #[Locked]
    public $obj;
    #[Locked]
    public $size = '';
//    public $name = 'نمایش در فوتر';
    #[Locked]
    public $checked;
    #[Locked]
    public $subject;
    #[Locked]
    public $btnType;
    #[Locked]
    public $color;
    #[Locked]
    public $checkedIcon = null;
    public function mount($obj,$type = 'switch',$subject = 'active',$color = 'emerald')
    {
        $this->color = $color;
        $this->btnType = $type;
        $this->subject = $subject;
        $this->obj = $obj;
        $this->checked = $obj->{$this->subject};

    }

    protected $rules = [
        'checked' => 'required|boolean',
    ];


    public function toggle($bool)
    {
        if (!super()){
            $this->dispatch('toast' ,title : 'You are not allowed to do this.' , type : 'error');
            return;
        }
        $this->checked = $bool;

        $val = Validator::make([
            'checked' => $this->checked
        ],$this->rules);

        if ($val->fails()){
            $this->dispatch('toast' ,title : 'Not change' , type : 'error');

        }else{
            $data = [$this->subject => $bool];

            $table = $this->obj->getTable() ;

            if ($table == 'comments' || $table =='answer' || $table == 'conversations'){
                if ($this->obj->new){
                    $data['new'] = false;

                    if ($table == 'comments'){

                    }
                }
            }
            $this->obj->update($data);

            if ($bool){
                $this->dispatch('toast' ,title : 'Actived' , type : 'success');

            }else{
                $this->dispatch('toast' ,title : 'Deactived' , type : 'warning');

            }
        }




    }
    public function render()
    {
        if ($this->btnType == 'switch'){
            return view('livewire.admin.active');
        }elseif ($this->btnType == 'btn'){
            return view('livewire.admin.active');
        }
    }
}

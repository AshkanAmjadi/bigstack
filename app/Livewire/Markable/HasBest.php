<?php

namespace App\Livewire\Markable;

use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class HasBest extends Component
{

    #[Locked]
    public $obj;

    public function mount($obj)
    {

        $this->obj = $obj;
    }

    #[On('bestAnswerSet')]
    #[On('bestAnswerDelete')]
    public function refresh2(){

    }

    public function render()
    {
        return view('livewire.markable.has-best');
    }
}

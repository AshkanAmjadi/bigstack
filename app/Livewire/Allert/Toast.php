<?php

namespace App\Livewire\Allert;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{

    #[On('toastAllert')]
    public function toast($title,$type)
    {
        $this->dispatch('toast' ,title : 'Deactived' , type : 'warning')->self();

    }

    public function render()
    {
        return view('livewire.allert.toast');
    }
}

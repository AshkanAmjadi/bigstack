<?php

namespace Modules\Content\App\Livewire\Category;

use Livewire\Attributes\Locked;
use Livewire\Component;

class Item extends Component
{
    #[Locked]
    public $subject;

    public function mount($subject)
    {
        $this->subject = $subject;
    }
    public function render()
    {
        return view('content::livewire.category.item');
    }
}

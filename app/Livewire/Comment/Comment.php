<?php

namespace App\Livewire\Comment;

use Livewire\Attributes\Locked;
use Livewire\Component;

class Comment extends Component
{

    #[Locked]
    public $comment;

    public function mount($comment)
    {

        $this->comment = $comment;

    }
    public function render()
    {
        return view('livewire.comment.comment');
    }
}

<?php

namespace App\Livewire\Markable;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Mark extends Component
{

    use WithRateLimiting;
    #[Locked]
    public $obj;
    #[Locked]
    public $id;
    #[Locked]
    public $iconSize = '';
    #[Locked]
    public $size = '';
    #[Locked]
    public $marked;
    #[Locked]
    public $title = '';



    public function mount($obj,$size = 'lg',$title = 'Article',$iconSize = 'md')
    {
        $this->iconSize = $iconSize;
        $this->title = $title;
        $this->obj = $obj;
        $this->size = $size;
    }


    public function toggle()
    {

        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch(
                'toast',
                title: "Due to high traffic, more than 10 requests per minute are not allowed. Try again in {$exception->secondsUntilAvailable} seconds.",
                type: 'error'
            );
            return;
        }

        if (!auth()->id()) {
            $this->dispatch(
                'toast',
                title: 'To bookmark, please register on our website 😊💕👈' . htmlAlink(route('auth.login'), 'Register'),
                type: 'info'
            );
            return;
        }

//        if ($this->count == 'null'){
//            $this->count = $this->obj->marks->count();
//        }
//        if ($this->marked == 'null'){
//            $this->marked = $this->obj->marks->where('user_id',auth()->id())->first();
//        }

        if ($this->obj->marks->where('user_id',auth()->id())->first()){

            \App\Models\Bookmark::query()->where(['user_id'=>auth()->id(),'markable_id'=>$this->obj->id,'markable_type'=>$this->obj->getMorphClass()])->delete();
            $this->marked = 'deleted';
            $this->dispatch('toast', title:'Unmarked', type: 'error');

        }else{

            $this->obj->marks()->create(['user_id'=>auth()->id()]);
            $this->marked = 'marked';
            $this->dispatch('toast', title:'Marked', type: 'success');

        }



    }
    public function render()
    {
        return view('livewire.markable.mark');
    }
}

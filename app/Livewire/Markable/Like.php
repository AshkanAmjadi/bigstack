<?php

namespace App\Livewire\Markable;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Like extends Component
{

    use WithRateLimiting;
    #[Locked]
    public $obj;
    #[Locked]
    public $id;
    #[Locked]
    public $size = '';
    #[Locked]
    public $iconSize = '';
    #[Locked]
    public $title = '';
    #[Locked]
    public $count;
    #[Locked]
    public $liked;


    public function mount($obj,$size = 'lg',$title = 'Article',$iconSize = 'md')
    {
        $this->iconSize = $iconSize;
        $this->title = $title;
        $this->obj = $obj;
        $this->count = $obj->likes_count ?: null;
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
                title: 'To add to favorites, please register on our website 😊💕👈' . htmlAlink(route('auth.login'), 'Register'),
                type: 'info'
            );
            return;
        }


//        if ($this->count == 'null'){
//            $this->count = $this->obj->likes->count();
//        }
//        if ($this->liked == 'null'){
//            $this->liked = $this->obj->likes->where('user_id',auth()->id())->first();
//        }

        if ($this->obj->likes()->where('user_id',auth()->id())->first()){

            \App\Models\Like::query()->where(['user_id'=>auth()->id(),'likeable_id'=>$this->obj->id,'likeable_type'=>$this->obj->getMorphClass()])->delete();
            $this->liked = 'deleted';
            if ($this->count !== null){
                $this->count--;
            }
            $this->dispatch('toast', title: 'your Like delelted', type: 'error');

        }else{

            $this->obj->likes()->create(['user_id'=>auth()->id()]);
            $this->liked = true;
            if ($this->count !== null){
                $this->count++;
            }
            $this->dispatch('toast', title:'Liked', type: 'success');

        }



    }

    public function render()
    {

        return view('livewire.markable.like');
    }
}

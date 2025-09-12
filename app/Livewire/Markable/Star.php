<?php

namespace App\Livewire\Markable;

use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseQuery\BaseQuery;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Star extends Component
{

    use WithRateLimiting;
    #[Locked]
    public $obj;
    #[Locked]
    public $title = '';
    #[Locked]
    public $stared;
    #[Locked]
    public $tactSaved = false;



    public function mount($obj)
    {
        $this->obj = $obj;
        $this->title = BaseQuery::getPersionOfTable($obj->getTable());


    }

    public function star($score)
    {
        $this->tactSaved = false;


        try {
            $this->rateLimit(10, 240);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch(
                'toast',
                title: "Due to high traffic, more than 10 requests in 4 minutes are not allowed. Try again in {$exception->secondsUntilAvailable} seconds.",
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


        if (!BaseMethod::checkUserInfoIsOk()) {
            $linkForPanel = route('user-panel.index');
            $linkForPanel = "<a class='alink' href='$linkForPanel'>پنل کاربری</a>";
            $this->dispatch('toast', title: "To submit a score, complete your profile via $linkForPanel ❤️", type: 'warning');
            return;
        }

        if ($this->obj->starTacts()->where(['user_id' => auth()->id()])->first()) {

            $this->dispatch('toast', title: 'Your rating has already been submitted ✍', type: 'info');

        } else {

            $this->obj->tacts()->create(['user_id' => auth()->id(), 'tact_type' => 'star', 'tact_value' => $score]);
            $this->tactSaved = true;
            $this->dispatch('toast', title: 'Your rating has been submitted', type: 'success');

        }



    }

    public function deleteScore(){
        $this->tactSaved = false;

        try {
            $this->rateLimit(5,10*60);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch(
                'toast',
                title: "Removing a rating more than 5 times within 10 minutes is not allowed, dear user. Try again in {$exception->minutesUntilAvailable} minute(s).",
                type: 'error'
            );
            return;
        }

        \App\Models\Tact::query()->where(['user_id'=>auth()->id(),'tactable_id'=>$this->obj->id,'tactable_type'=>$this->obj->getMorphClass()])->delete();


    }

    public function render()
    {
        return view('livewire.markable.star');
    }
}

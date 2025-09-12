<?php

namespace App\Livewire\Markable;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Livewire\Component;

class AnswerTact extends Component
{

    use WithRateLimiting;
    #[Locked]
    public $obj;
    #[Locked]
    public $title = '';
    #[Locked]
    public $tactSaved = false;


    public function mount($obj)
    {
        $this->obj = $obj;

    }



    public function tact($score)
    {
        $this->tactSaved = false;

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
                title: 'To give a rating, please register on our website 😊💕👈' . htmlAlink(route('auth.login'), 'Register'),
                type: 'info'
            );
            return;
        }

        if ($this->obj->tacts()->where(['user_id' => auth()->id()])->first()) {
            $this->dispatch('toast', title: 'You have already submitted your rating ✍', type: 'info');
        } else {
            if ($score) {
                $this->obj->tacts()->create([
                    'user_id' => auth()->id(),
                    'tact_type' => 'tact',
                    'tact_value' => $score
                ]);
                $this->dispatch('toast', title: 'Your opinion has been recorded as useful', type: 'success');
                $this->tactSaved = 'ok';
            } else {
                $this->obj->tacts()->create([
                    'user_id' => auth()->id(),
                    'tact_type' => 'tact',
                    'tact_value' => $score
                ]);
                $this->dispatch('toast', title: 'Your opinion has been recorded as not useful', type: 'success');
                $this->tactSaved = 'bad';
            }

            Cache::forget('conversations' . $this->obj->conversation_id . 'schema');
        }



    }


    public function deleteScore(){

        try {
            $this->rateLimit(5, 10 * 60);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch(
                'toast',
                title: "Removing a rating more than 5 times within 10 minutes is not allowed, dear user. Try again in {$exception->minutesUntilAvailable} minute(s).",
                type: 'error'
            );
            return;
        }
        $this->tactSaved = false;

        \App\Models\Tact::query()
            ->where([
                'user_id' => auth()->id(),
                'tactable_id' => $this->obj->id,
                'tactable_type' => $this->obj->getMorphClass()
            ])->delete();

        $this->dispatch('toast', title: 'Your rating has been removed', type: 'info');

        Cache::forget('conversations' . $this->obj->conversation_id . 'schema');



    }
    public function render()
    {
        return view('livewire.markable.answer-tact');
    }
}

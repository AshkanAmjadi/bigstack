<?php

namespace App\Livewire\Markable;

use App\facade\BaseMethod\BaseMethod;
use App\facade\Notification\Notification;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class BestAnswer extends Component
{

    use WithRateLimiting;
    #[Locked]
    public $obj;
    #[Locked]
    public $conversation;
    #[Locked]
    public $title = '';

    public function mount($obj, $conversation)
    {

        $this->obj = $obj;
        $this->conversation = $conversation;
    }


    public function best()
    {

        try {
            $this->rateLimit(10, 240);
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
                title: 'To perform this action, please register on our website 😊💕👈' . htmlAlink(route('auth.login'), 'Register'),
                type: 'info'
            );
            return;
        }

        if (!BaseMethod::checkUserInfoIsOk()) {
            $linkForPanel = route('user-panel.index');
            $linkForPanel = "<a class='alink' href='$linkForPanel'>پنل کاربری</a>";
            $this->dispatch('toast', title: "To mark the best answer, complete your profile via $linkForPanel ❤️", type: 'warning');

            return;
        }

        if ($this->conversation->user_id == auth()->id() or super()) {

            if (!$this->conversation->has_best) {
                if ($this->obj->active){

                    if ($this->conversation->user_id == $this->obj->user_id){
                        $this->dispatch('toast', title: 'You can only select an answer other than your own as the best answer', type: 'error');
                        return;
                    }

                    $this->conversation->update(['has_best' => true]);
                    $this->obj->update(['best' => true]);

                    $data = [
                        'first' => htmlAlink(route('conversation.show', ['conversation' => $this->conversation->slug]), $this->conversation->title),
                    ];
                    Notification::user($this->obj->user_id, 'success', 'bestAnswer', $data);

                    $this->dispatch('toast', title: 'Your best answer has been submitted, thank you dear user 💕', type: 'success');


                    $this->dispatch('bestAnswerSet');
                }else{
                    $this->dispatch('toast', title: 'This answer is awaiting approval', type: 'error');
                }
            } else {
                $this->dispatch('toast', title: 'The best answer for this question has already been submitted', type: 'info');
            }

        } else {
            $this->dispatch('toast', title: 'Only the author of the question can select the best answer', type: 'error');

        }


    }

    #[On('bestAnswerSet')]
    #[On('bestAnswerDelete')]
    public function refresh2()
    {

    }


//    public function deleteScore()
//    {
//
//        try {
//            $this->rateLimit(5, 2 * 60 * 60);
//        } catch (TooManyRequestsException $exception) {
//            $this->dispatch('toast', title: "بیشتر از 2 بار در 2 ساعت حذف بهترین پاسخ ممنوعه کاربر عزیز.$exception->minutesUntilAvailable دقیقه دیگه امتحان کن", type: 'error');
//            return;
//        }
//
//        if (!auth()->id()) {
//            $this->dispatch('toast', title: 'برای این کار بیا تو سایت ما ثبت نام کن 😊💕', type: 'info');
//            return;
//        }
//        if ($this->conversation->user_id == auth()->id() or super()) {
//            $this->conversation->update(['has_best' => false]);
//            $this->obj->update(['best' => false]);
//
//            $this->dispatch('toast', title:'عنوان بهترین پاسخ حذف شد', type: 'warning');
//
//            $this->dispatch('bestAnswerDelete');
//
//        } else {
//            $this->dispatch('toast', title: 'فقط نویسنده پرسش بهترین را مشخص میکند', type: 'error');
//
//        }
//
//    }

    public function render()
    {
        return view('livewire.markable.best-answer');
    }
}

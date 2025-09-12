<?php

namespace Modules\User\App\Livewire\Profile;

use App\facade\Module\ModuleFacade;
use Modules\User\App\Models\ActiveCode;
use Modules\User\App\Models\Phone as PhoneModel;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Phone extends Component
{
    use WithRateLimiting;

    #[Locked]
    public $phone;

    #[Locked]
    public $secondPhone = null;

    #[Locked]
    public $gotIt = false;

    public function getPhone($phone)
    {
        if (!auth()?->id()) {
            $this->dispatch('toast', title: 'To change your phone number, please register on the website 😊💕👈' . htmlAlink(route('auth.login'), 'Register'), type: 'info');
            return;
        }

        if (
            !RateLimiter::attempt('ip:' . \request()->ip(), 8, function () {
                return true;
            }, 60 * 60 * 6)
        ) {
            $s = RateLimiter::availableIn('ip:' . \request()->ip());
            $s = secondsToTime($s);
            ModuleFacade::logIfAvailable(level: 'warning', subject: auth()->user(), event: 'change_phone_failed', description: 'Excessive failed attempts to change mobile number detected from recorded IP address', logName: 'auth');
            $this->dispatch('toast', title: "Due to high request volume, you cannot log in for another {$s}", type: 'error');
            return;
        }

        $phone = str_replace(' ', '', $phone);

        $validation = Validator::make(['phone' => $phone], [
            'phone' => ['required', 'numeric', 'regex:/^09([0-9]){9}$/', 'ir_mobile:zero']
        ]);

        if ($validation->fails()) {
            $this->dispatch('toast', title: 'Invalid mobile phone number.', type: 'error');
            return;
        }

        $newPhone = $validation->validated()['phone'];

        $phoneObj = PhoneModel::query()->where('phone', '=', $newPhone)->first();
        if ($phoneObj) {
            if ($phoneObj->bann) {
                $this->dispatch('toast', title: 'This phone number is banned.', type: 'error');
                return;
            }

            if ($phoneObj->user_id == auth()->id()) {
                $this->dispatch('toast', title: 'This is your current phone number.', type: 'error');
                return;
            }

            $this->dispatch('toast', title: 'This phone number is already registered to another user.', type: 'error');
            return;
        }

        if (
            !RateLimiter::attempt('phone:' . $newPhone, 4, function () {
                return true;
            }, 60 * 60)
        ) {
            $s = RateLimiter::availableIn('phone:' . $newPhone);
            $s = secondsToTime($s);
            $this->dispatch('toast', title: "Please try again for this mobile number in {$s} minutes", type: 'error');
            return;
        }

        if (
            !RateLimiter::attempt('phone:resend' . $newPhone, 1, function () {
                return true;
            }, 120)
        ) {
            $s = RateLimiter::availableIn('phone:resend' . $newPhone);
            $s = secondsToTime($s);
            $this->dispatch('toast', title: "You can request a verification code again in {$s}", type: 'error');
            return;
        }

        $code = ActiveCode::query()->wherePhone($newPhone)->first();

        if (is_null($code)) {
            ActiveCode::generateCode($newPhone);
            $this->gotIt = true;
            $this->secondPhone = $newPhone;
            ModuleFacade::logIfAvailable(
                subject: auth()->user(),
                event: 'sms_edit_phone_sended',
                description: 'Authentication code for changing phone number was successfully sent to the specified number',
                logName: 'auth',
                properties: [
                    'for' => [
                        'phone' => [
                            'old' => auth()->user()?->MainPhone?->phone,
                            'new' => $newPhone,
                        ]
                    ]
                ]
            );
            $this->dispatch('toast', title: 'The 6-digit code was successfully sent to you', type: 'info');
        } else {
            $status = ActiveCode::VerifyCode($code->code, $newPhone);

            if (!$status) {
                ActiveCode::generateCode($newPhone);
                $this->gotIt = true;
                $this->secondPhone = $newPhone;
                ModuleFacade::logIfAvailable(
                    subject: auth()->user(),
                    event: 'sms_edit_phone_sended',
                    description: 'Authentication code for changing phone number was successfully sent to the specified number',
                    logName: 'auth',
                    properties: [
                        'for' => [
                            'phone' => [
                                'old' => auth()->user()?->MainPhone?->phone,
                                'new' => $newPhone,
                            ]
                        ]
                    ]
                );
                $this->dispatch('toast', title: 'The 6-digit code was successfully sent to you', type: 'info');
            } else {
                $this->dispatch('toast', title: 'Please try again for this mobile number in 2 minutes', type: 'error');
                return;
            }
        }
    }

    public function getCode($code)
    {
        if (!auth()->id()) {
            $this->dispatch('toast', title: 'To change your mobile number, please register on the website 😊💕👈' . htmlAlink(route('auth.login'), 'Register'), type: 'info');
            $this->gotIt = false;
            $this->secondPhone = null;
            return;
        }

        $validation = Validator::make(['code' => $code], [
            'code' => ['required', 'numeric', 'digits:6']
        ]);

        if ($validation->fails()) {
            $this->gotIt = false;
            $this->secondPhone = null;
            $this->dispatch('toast', title: 'You entered the code incorrectly. Please try again in 2 minutes.', type: 'error');
        } else {
            $phoneObj = PhoneModel::query()->where('phone', '=', $this->secondPhone)->first();
            if ($phoneObj) {
                if ($phoneObj->bann) {
                    $this->dispatch('toast', title: 'This phone number is banned.', type: 'error');
                    $this->gotIt = false;
                    $this->secondPhone = null;
                    return;
                }

                if ($phoneObj->user_id == auth()->id()) {
                    $this->dispatch('toast', title: 'This is your current phone number.', type: 'error');
                    $this->gotIt = false;
                    $this->secondPhone = null;
                    return;
                }

                $this->dispatch('toast', title: 'This phone number is already registered to another user.', type: 'error');
                $this->gotIt = false;
                $this->secondPhone = null;
                return;
            }

            $status = ActiveCode::VerifyCode($code, $this->secondPhone);

            if (!$status) {
                ActiveCode::query()->where(['phone' => $this->secondPhone])->delete();

                $this->dispatch('toast', title: 'You entered the code incorrectly or too late. Please try again in 2 minutes.', type: 'error');
                $this->gotIt = false;
                $this->secondPhone = null;
                return;
            }

            ActiveCode::query()->where(['phone' => $this->secondPhone])->delete();

            $mainPhone = auth()->user()->MainPhone;
            if ($mainPhone) {
                ModuleFacade::logIfAvailable(
                    level: 'notice',
                    subject: auth()->user(),
                    event: 'phone_updated',
                    description: 'Previous phone number removed and a new phone number registered by the user',
                    logName: 'auth',
                    properties: [
                        'changes' => [
                            'phone' => [
                                'old' => $mainPhone->phone,
                                'new' => $this->secondPhone,
                            ]
                        ]
                    ]
                );
                $this->dispatch('toast', title: 'Your new mobile number has been successfully registered 😇', type: 'success');
                $mainPhone->update(['phone' => $this->secondPhone, 'verify' => true, 'loged' => now()]);
            } else {
                ModuleFacade::logIfAvailable(level: 'notice', subject: auth()->user(), event: 'phone_added', description: 'The user registered a new phone number', logName: 'auth', properties: ['phone' => $this->secondPhone]);
                auth()->user()->mainPhone()->create(['phone' => $this->secondPhone, 'verify' => true, 'loged' => now()]);
                $this->dispatch('toast', title: 'Your previous mobile number was removed and the new one was successfully registered 😇', type: 'success');
            }
            $this->gotIt = false;
            $this->secondPhone = null;
        }
    }

    public function render()
    {
        return view('user::livewire.profile.phone');
    }
}

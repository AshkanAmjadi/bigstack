<?php

namespace Modules\User\App\Http\Controllers\Auth;



use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseRequest\BaseRequest;

use App\facade\Module\ModuleFacade;
use App\facade\Notification\Notification;
use App\Http\Controllers\Controller;
use App\Services\LoginSecurity\LoginTracker;
use Illuminate\Support\Facades\Auth;
use Modules\User\App\Models\ActiveCode;
use Modules\User\App\Models\Phone;
use Modules\User\App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class loginControlle extends Controller
{

    private $module = 'user::';


    public function logout()
    {

        ModuleFacade::logIfAvailable(subject: auth()->user(), event: 'logout', description: 'user logout', logName: 'auth');
        app(LoginTracker::class)->loadCurrentLogin()->revoke();
        Auth::logout(); // this for default
        toast('You have logged out of our website. Good luck 👋', 'info')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect('/');
    }

    public function loginShow()
    {

        return view($this->module.'auth.enter');

    }

    public function login(Request $request)
    {




//todo        BaseMethod::dangerIp();
//        RateLimiter::clear('phone:'.$validData['phone']);

        if (
            !RateLimiter::attempt('ip:' . \request()->ip(), 8, function () {
                return true;
            }, 60 * 60 * 6)
        ) {
            $s = RateLimiter::availableIn('ip:' . \request()->ip());
            $s = secondsToTime($s);
            ModuleFacade::logIfAvailable(
                level: 'warning',
                subject: new User(),
                event: 'login_failed_with_phone',
                description: 'Excessive failed login attempts detected from the recorded IP address',
                logName: 'guest'
            );

            return redirect()->back()->withErrors([
                'code' => "Due to high request volume, you cannot log in for another {$s} seconds."
            ]);
        }

        BaseRequest::mergePrToEnRequest($request, ['phone']);

        $validData = $request->validate([
            'phone' => ['required', 'numeric', 'regex:/^09([0-9]){9}$/', 'ir_mobile:zero']
        ]);


        $phoneObj = Phone::query()->where('phone', $validData['phone'])->first();

        if ($phoneObj) {
            if ($phoneObj->bann) {
                return redirect()->back()->withErrors(['code' => 'This phone number is banned.']);
            }
        }

        $phone = $validData['phone'];




        if (
            !RateLimiter::attempt('phone:' . $validData['phone'], 4, function () {
                return true;
            }, 60 * 60 * 2)
        ) {

            $s = RateLimiter::availableIn('phone:' . $validData['phone']);
            $s = secondsToTime($s);
            ModuleFacade::logIfAvailable(
                level: 'warning',
                subject: new User(),
                event: 'login_failed_with_phone',
                description: 'Excessive failed login attempts detected for the registered mobile phone number',
                logName: 'guest',
                properties: [
                    'phone' => $validData['phone']
                ]
            );

            return redirect()->back()->withErrors([
                'code' => "Please try again for this mobile number in {$s} minutes."
            ]);

        }
        if (
            !RateLimiter::attempt('phone:'.$phone.'ip:' . \request()->ip(), 1, function () {
                return true;
            }, 120)
        ) {
            $s = RateLimiter::availableIn('phone:'.$phone.'ip:' . \request()->ip());
            $s = secondsToTime($s);
            return redirect()->back()->withErrors(['code' => "You can request a verification code again in $s"]);

        }
        $code = ActiveCode::query()->wherePhone($phone)->first();


        if (is_null($code)) {
            ActiveCode::generateCode($phone);
        } else {
            $status = ActiveCode::VerifyCode($code->code, $phone);

            if (!$status) {
                ActiveCode::generateCode($phone);
            } else {
                return redirect()->back()->withErrors(['code' => 'Please try again for this mobile number in 2 minutes']);
            }

        }
        $request->session()->flash('auth', [
            'phone' => $phone,
        ]);
        ModuleFacade::logIfAvailable(
            subject: new User(),
            event: 'sms_login_sended',
            description: 'Authentication code for website login was successfully sent to the specified phone number',
            logName: 'guest',
            properties: [
                'phone' => $phone
            ]
        );

        toast('The code has been sent to you 📲', 'success')
            ->autoClose(5000)
            ->position('bottom-end')
            ->timerProgressBar();


        return redirect(route('auth.verifyCode'));


    }

    public function verifyCodeShow(Request $request)
    {

        if (!$request->session()->has('auth')) {
            return redirect(route('auth.login'));
        }

        $request->session()->reflash();


        return view($this->module.'auth.verifyNumber');

    }

    public function verifyCode(Request $request)
    {
        if (!$request->session()->has('auth')) {
            return redirect(route('auth.login'));
        }


        $token = $request->validate([
            'verifyCode' => ['required', 'numeric', 'digits:6']
        ]);


        $phone = $request->session()->get('auth.phone');

        $status = ActiveCode::VerifyCode($token['verifyCode'], $phone);

        if (!$status) {
            ModuleFacade::logIfAvailable(
                subject: new User(),
                event: 'sms_login_failed',
                description: 'Unsuccessful attempt (due to delayed entry or incorrect SMS code) from the registered mobile phone number',
                logName: 'guest',
                properties: [
                    'phone' => $phone
                ]
            );

            return view($this->module . 'auth.enter')->withErrors([
                'code' => 'You entered the code incorrectly or too late. Please try again in 3 minutes.'
            ]);
//            return redirect(route('auth.login')) ;
        }

        ActiveCode::query()->where(['phone' => $phone])->delete();

        $phone = Phone::query()->where(['phone' => $phone])->firstOrCreate(['phone' => $phone]);

        if ($phone->user_id) {
            $user = $phone->user;
            if (!$user->by_phone) {
                $user->update(['by_phone' =>true]);
            }
            $phone->update(['verify' => true]);
        } else {
            $user = User::query()->create(['by_phone' => true]);
            $data = [
                'first' => 'No name',
                'second' => $phone->phone,
            ];
            Notification::admin('success', 'userAdded', $data);

            ModuleFacade::logIfAvailable(
                level: 'good',
                subject: $user,
                event: 'user_created',
                description: 'A new user was created with a mobile number',
                logName: 'auth',
                properties: [
                    'phone' => $phone->phone
                ]
            );

            $phone->update([
                'user_id' => $user->id,
                'verify' => true
            ]);

        }

        if (app()->make(LoginTracker::class)->customLogin($user,true,'Phone')) {

            $phone->update(['loged' => now()]);
//            if (\request()->user()->logins()->get()->count() >= 2){
//
//                ModuleFacade::logIfAvailable(level: 'notice',subject: $user, event: 'login_other', description: 'ورود موفق کاربر با شماره موبایل توسط سیستم و آیپی جدید  که در اطلاعات این لاگ ذخیره شده.', logName: 'auth', properties: [ 'phone' => $phone->phone ]);
//                Notification::user(auth()->id(),'warning','loginWithOtherIp',['first'=> $request->ip()]);
//
//            }

            if (BaseMethod::checkUserInfoIsOk($user->id)) {
                toast('Welcome to our website 👋', 'success')
                    ->autoClose(5000)
                    ->position('bottom-end')
                    ->timerProgressBar();

                ModuleFacade::logIfAvailable(
                    subject: $user,
                    event: 'login',
                    description: 'Successful user login via mobile number with complete information.',
                    logName: 'auth',
                    properties: [
                        'phone' => $phone->phone
                    ]
                );

                return redirect(route('home'));
            } else {
                ModuleFacade::logIfAvailable(
                    level: 'notice',
                    subject: $user,
                    event: 'login',
                    description: 'Successful user login via mobile number with incomplete information.',
                    logName: 'auth',
                    properties: [
                        'phone' => $phone->phone
                    ]
                );

                toast('Please complete all required information to continue using the website. 🌹🌹', 'warning')
                    ->autoClose(5000)
                    ->position('bottom-end')
                    ->timerProgressBar();

                return redirect(route('user-panel.index'));
            }


        }
        toast('Login was not successful ❌', 'error')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route('auth.login'));

    }

}


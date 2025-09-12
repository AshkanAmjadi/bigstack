<?php

namespace Modules\User\App\Http\Controllers\Auth;


use App\facade\BaseMethod\BaseMethod;
use App\facade\Module\ModuleFacade;
use App\facade\Notification\Notification;
use App\Http\Controllers\Controller;
use App\Services\LoginSecurity\LoginTracker;
use Illuminate\Support\Facades\Auth;
use Modules\User\App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class googleAuthController extends Controller
{


    public function redirect()
    {


        return Socialite::driver('google')->redirect();

    }


    public function callback(Request $request)
    {


        try {
            $userGoogle = Socialite::driver('google')->user();


            $user = User::query()->where('email', '=', $userGoogle->email)->first();


            if (!$user) {

                $user = User::query()->create([

                    'name' => $userGoogle->name,
                    'email' => $userGoogle->email,
                    'email_verify' => true


                ]);

                ModuleFacade::logIfAvailable(
                    level: 'good',
                    subject: $user,
                    event: 'user_created',
                    description: 'new user with new email',
                    logName: 'auth',
                    properties: [
                    'name' => $userGoogle->name,
                    'email' => $userGoogle->email,
                    ]
                );
                $data = [
                    'first' => $user->name,
                    'second' => $user->email
                ];
                Notification::admin('success', 'userAdded', $data);


            }

//

            app()->make(LoginTracker::class)->customLogin($user,true,'Google');

//
//            if (\request()->user()->logins()->get()->count() >= 2) {
//                ModuleFacade::logIfAvailable(
//                    level: 'notice',
//                    subject: $user,
//                    event: 'login_other',
//                    description: 'ورود موفق کاربر با ایمیل توسط سیستم و آیپی جدید  که در اطلاعات این لاگ ذخیره شده.',
//                    logName: 'auth',
//                    properties: [
//                    'name' => $userGoogle->name,
//                    'email' => $userGoogle->email,
//                    ]
//                );
//                Notification::user(auth()->id(), 'warning', 'loginWithOtherIp', ['first' => $request->ip()]);
//
//            }


            if (BaseMethod::checkUserInfoIsOk($user->id)) {

                ModuleFacade::logIfAvailable(
                    subject: $user,
                    event: 'login',
                    description: 'User successfully authenticated via mobile number with full profile information.',
                    logName: 'auth',
                    properties: [
                        'name' => $userGoogle->name,
                        'email' => $userGoogle->email,
                    ]
                );

                toast('Welcome to our website 👋', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();


                return redirect(route('home'));
            } else {

                ModuleFacade::logIfAvailable(
                    level: 'notice',
                    subject: $user,
                    event: 'login',
                    description: 'Successful user login via mobile number with incomplete information.',
                    logName: 'auth',
                    properties: [
                        'name' => $userGoogle->name,
                        'email' => $userGoogle->email,
                    ]
                );

                toast('Please make sure to complete the required information to continue using the website. 🌹🌹', 'warning')->autoClose(5000)->position('bottom-end')->timerProgressBar();

                return redirect(route('user-panel.index'));

            }


        } catch (\Exception $e) {

            if (auth()) {
                auth()->logout();
            }

            ModuleFacade::logIfAvailable(
                level: 'error',
                subject: new User(),
                event: 'login_failed_with_google',
                description: 'Unsuccessful login attempt with email via Google.',
                logName: 'guest',
                properties: ['google' => $e->getMessage()]
            );


            Log::error($e);
            return 'error';
        }


    }
}

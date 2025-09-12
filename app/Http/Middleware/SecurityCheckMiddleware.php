<?php

namespace App\Http\Middleware;

use App\facade\BaseRequest\BaseRequest;
use App\facade\Module\ModuleFacade;
use App\Services\LoginSecurity\LoginTracker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityCheckMiddleware
{
    /**
     * سرویس رهگیری لاگین
     */


    public object $loginTracker;

    /**
     * سازنده کلاس
     */
    public function __construct()
    {
        $this->loginTracker = app(LoginTracker::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {




        $user_remember = BaseRequest::getRememberTokenInfo();


        $user_remember ? Log::info('info', [
            'token' => $user_remember->get('token'),
            'user_id' => $user_remember->get('user_id'),
        ]) : null;

        Log::info('infosession', [

            'session' => session()->all(),
            'session_Id' => session()->id()
        ]);

        // اگر کاربر لاگین کرده است
        $isLogin = Auth::check();
        if ($isLogin) {
            $user = Auth::user();


            $currentLogin = $this->loginTracker->loadCurrentLogin($user);
            //اگر لاگین پیدا نشد، خروج خودکار
            if (!$currentLogin) {
                ModuleFacade::logIfAvailable(
                    subject: $user,
                    event: 'logout',
                    description: 'User session not found',
                    logName: 'auth'
                );

                Auth::logout();

                toast('You have been logged out. Please try again.', 'error')
                    ->autoClose(5000)
                    ->position('bottom-end')
                    ->timerProgressBar();

                return redirect('/');

            }





        } else {
            if (config('login-security')["delete_remember_after_check_user"]) {
                BaseRequest::getAndForgetRememberToken();
            }
        }


        $response = $next($request);

        //اقدامات بعد از پردازش و قبل از ارسال پاسخ به کاربر

        return $response;
    }
}

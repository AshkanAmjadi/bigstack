<?php

namespace App\Providers;


use App\Extensions\Auth\LoginSecurityUserProvider;
use App\Http\Middleware\SecurityCheckMiddleware;
use App\Listeners\NotifySuspiciousLogin;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\User\App\Models\User;
use App\Services\LoginSecurity\LoginTracker;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
//use Laravel\Sanctum\Events\TokenCreated;
//use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Cookie;

class LoginSecurityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // ثبت سرویس LoginTracker به صورت singleton
        $this->app->singleton(LoginTracker::class, function ($app) {
            return new LoginTracker($app['config']['login-security']);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {


        // انتشار فایل‌های کانفیگ
        $this->publishes([
            __DIR__.'/../config/login-security.php' => config_path('login-security.php'),
        ], 'login-security-config');


        //  ثبت middleware
        $this->registerMiddleware();

        // گوش دادن به رویدادها
        $this->registerEventListeners();

        // ثبت Guard و Provider سفارشی
        $this->registerAuthExtensions();
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];

        // //         ثبت میدلور
        $router->aliasMiddleware('security-check', SecurityCheckMiddleware::class);

        // // افزودن میدلور به گروه web
        if (config('login-security.enable_middleware', true)) {
            $router->pushMiddlewareToGroup('web', SecurityCheckMiddleware::class);
        }
    }
    /**
     * ثبت شنوندگان رویداد
     */
    protected function registerEventListeners(): void
    {
        // رویداد لاگین موفقیت‌آمیز
        Event::listen(Login::class, function (Login $event) {
                $this->app->make(LoginTracker::class)->track($event->user, $event->remember);
        });

        // رویداد ایجاد توکن سنکتوم
//        if (class_exists(Sanctum::class) && class_exists(TokenCreated::class)) {
//            Event::listen(TokenCreated::class, function (TokenCreated $event) {
//                $this->app->make(LoginTracker::class)->trackApiToken(
//                    $this->findUserById($event->userId),
//                    $event->token->id
//                );
//            });
//        }

        // رویداد خروج
        Event::listen(Logout::class, function (Logout $event) {
            // پاک کردن کوکی remember-me
            $guard = Auth::guard('web');               // یا Auth::guard('web')
            $name  = $guard->getRecallerName();    // مثال: "remember_web"
            Cookie::queue(Cookie::forget($name));


            Session::invalidate();
            Session::regenerateToken();
        });

        // ثبت شنونده برای رویداد فعالیت مشکوک
//        if (class_exists(SuspiciousLoginDetected::class) && class_exists(NotifySuspiciousLogin::class)) {
//            Event::listen(SuspiciousLoginDetected::class, NotifySuspiciousLogin::class);
//
//        }
    }

    /**
     * ثبت پرووایدر و گارد سفارشی برای auth
     */
    protected function registerAuthExtensions(): void
    {
        // ثبت پرووایدر سفارشی
        Auth::provider('login-security', function ($app, array $config) {
            return new LoginSecurityUserProvider(
                $app['hash'],
                $config['model'],
                $app->make(LoginTracker::class)
            );
        });


    }

    /**
     * پیدا کردن کاربر با شناسه
     */
    protected function findUserById($id): ?Authenticatable
    {
        return User::find($id);
    }
}

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ClearSessionAfterRequest
{
    public function handle($request, Closure $next)
    {
        // اجرا شدن بقیه میدلورها و کنترلر
        $response = $next($request);

        // پس از ارسال response به کلاینت
        Session::invalidate();   // پاک‌سازی داده‌های session و تغییر session_id
        Session::flush();        // حذف تمام مقادیر session

        return $response;
    }
}

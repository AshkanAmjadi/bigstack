<?php


namespace App\facade\BaseRequest;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class BaseRequestService
{


    public function mergePrToEnRequest($request,array $data)
    {

        foreach ($data as $value){

            $request->merge([$value => convertPersianToEnglish($request->input($value))]);

        }

    }
    public function replaceToSpace($request,array $data,$replacement = '')
    {

        foreach ($data as $value){

            $request->merge([$value => singleRemoveSpace($request->input($value),'_')]);

        }

    }

    public function getRememberTokenInfo()
    {

        $cookieName = \Illuminate\Support\Facades\Auth::getRecallerName(); // معمولاً خروجی: remember_web_{hash}
        $rememberToken = request()->cookie($cookieName);

        if (empty($rememberToken)) { return false; }

        $danger = false;
        $rememberToken = explode('|',request()->cookie($cookieName)) ;

        if (count($rememberToken) < 2) { $danger = true; }
        $all = Collection::make([

            'user_id' => $rememberToken[0],
            'token' => $rememberToken[1],
            'danger' => $danger,

        ]);


        return $all;



    }


    function getSessionDataById(string $sessionId): ?array
    {
        // 1. گرفتن کنترل‌کننده (Handler) درایور سشن فعلی
        // Session::getHandler() به شما آبجکتی می‌دهد که مسئول خواندن و نوشتن فیزیکی داده‌هاست.
        $sessionHandler = Session::getHandler();

        // 2. خواندن داده‌های خام سشن با استفاده از ID
        // متد read() یک رشته سریال‌شده یا null (اگر سشن وجود نداشته باشد) برمی‌گرداند.
        $raw_data = $sessionHandler->read($sessionId);

        // 3. اگر داده‌ای وجود داشت، آن را unserialize کنید
        if ($raw_data) {
            // داده‌ها با متد serialize() در PHP ذخیره شده‌اند.
            // ما با unserialize() آن‌ها را به آرایه تبدیل می‌کنیم.
            // @ برای جلوگیری از خطا در صورت نامعتبر بودن داده‌ها استفاده می‌شود.
            $data = @unserialize($raw_data);

            // اگر unserialize موفقیت‌آمیز بود و نتیجه یک آرایه بود، آن را برگردان
            if (is_array($data)) {
                return $data;
            }
        }

        // اگر سشن پیدا نشد یا داده‌ها معتبر نبودند
        return null;
    }


    function getAndForgetRememberToken(): null|string
    {

        $guard = Auth::guard('web');               // یا Auth::guard('web')
        $name  = $guard->getRecallerName();
        $rememberToken = request()->cookie($name);// مثال: "remember_web"
        Cookie::queue(Cookie::forget($name));

        return $rememberToken;

    }



}

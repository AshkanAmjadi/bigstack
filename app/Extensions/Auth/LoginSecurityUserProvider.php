<?php

namespace App\Extensions\Auth;

use App\facade\BaseRequest\BaseRequest;
use App\Services\LoginSecurity\LoginTracker;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Log;

class LoginSecurityUserProvider extends EloquentUserProvider
{
    /**
     * سرویس مدیریت لاگین
     */
    protected LoginTracker $loginTracker;

    /**
     * سازنده کلاس
     */
    public function __construct($hasher, $model, LoginTracker $loginTracker)
    {
        parent::__construct($hasher, $model);
        $this->loginTracker = $loginTracker;
    }

    /**
     * بازیابی کاربر با شناسه و توکن remember me
     *
     * @param mixed $identifier
     * @param string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {

        $model = $this->createModel();

        // بازیابی کاربر با شناسه
        $retrievedModel = $this->newModelQuery($model)
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();

        if (!$retrievedModel) {
            Log::warning('User with the specified ID was not found', ['user_id' => $identifier]);
            return null;
        }

        //todo توی یک سری اقدامات یه چیزایی بایت توی جدول یوزر ثبت بشه که قرنطینس . بلاکه . یا توصیه ای هست.


        // بررسی لاگین‌های فعال با توکن remember me مطابق
        $login = $retrievedModel->loginTrackings()
            ->where('remember_token', $token)
            ->where('expires_at', '>', now())
            ->first();


        if (!$login) {
            /**
             * اینجا بعد از این که لاگین فعال پیدا نشد میبینیم که آیا قبلا استفاده شده یا نه
             */
            if (config('use_invalidated_token')){
                $token_status = $this->loginTracker->isTokenInvalidated($token, $retrievedModel->id);
                if($token_status){
                    //اقدام امنیتی جدی -- تست شده✅
                    if ($token_status['reason'] == 'remembered'){
                        $this->loginTracker->forceSecurityAction('hard','use_invalidated_token',[],$retrievedModel);
                    }

                    return null;
                }
            }


            Log::warning('No valid login found with the remember token', [
                'user_id' => $identifier,
                'token_prefix' => $token
            ]);
            //اقدام امنیتی عادی -- تست شده✅
            $this->loginTracker->forceSecurityAction('easy','token_not_exist',[],$retrievedModel);
            return null;
        }

        //تنها زمانی باید بشه از ریممبر توکن استفاده کرد که سشن از بین رفته باشه . دلیلی نداره که وقتی سشن هنوز زندس از ریممبر توکن استفاده بشه. کاملا مشکوکه
        if ($loginsession = BaseRequest::getSessionDataById($login->session_id)){
            Log::warning('Attempt to use remember me while the session still exists.', [
                '$loginsession' => $loginsession,
            ]);
            //اقدام امنیتی جدی --تست شده✅
            $this->loginTracker->forceSecurityAction('hard','session_still_alive',[],$retrievedModel);
            return null;
        }

        // بررسی امنیتی برای دستگاه و IP و در صورت مشکل داشتن اتوماتیک ترک حذف خواهد شد و اطلاعات امنیتی به آن الهاق میشود.-- تست شده
        if (!$this->loginTracker->verifyLoginSecurity($login)) {
            return null;
        }

        $this->loginTracker->performTokenRotation($retrievedModel, $login , $token);


        return $retrievedModel;
    }

    /**
     * به‌روزرسانی توکن remember me
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        //برای لاگین جدید میاد

        Log::info('updateRememberToken', [
            '$token' => $token
        ]);

        $this->loginTracker->remember_token = $token;

    }



}

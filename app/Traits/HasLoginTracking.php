<?php

namespace App\Traits;

use App\Models\LoginTracking;
use App\Services\LoginSecurity\LoginTracker;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\App;

trait HasLoginTracking
{
    /**
     * توکن فعلی برای remember me
     */
    public ?string $remember_token = null;

    /**
     * رابطه با لاگین‌ها
     */
    public function loginTrackings(): MorphMany
    {
        return $this->morphMany(LoginTracking::class, 'user');
    }

    /**
     * دریافت لاگین فعلی
     */
    public function getCurrentLoginAttribute()
    {

        return App::make(LoginTracker::class)->loadCurrentLogin($this);
    }

    /**
     * دریافت همه لاگین‌های فعال
     */
    public function getActiveLoginsAttribute()
    {
        return $this->loginTrackings()
            ->orderByDesc('last_activity_at')
            ->get();
    }
    /**
     * دریافت همه لاگین‌های فعال
     */
    public function getAllLoginsAttribute()
    {
        return $this->loginTrackings()->withTrashed()
            ->orderBy('deleted_at')
            ->orderByDesc('last_activity_at')
            ->get();
    }

    /**
     * خارج کردن از یک دستگاه خاص
     */
    public function logoutDevice(int $loginId): bool
    {
        return App::make(LoginTracker::class)->logout($loginId);
    }

    /**
     * خارج کردن از همه دستگاه‌ها
     */
    public function logoutAllDevices(): int
    {
        return App::make(LoginTracker::class)->logoutAll($this);
    }

    /**
     * خروج از همه دستگاه‌ها به جز دستگاه فعلی
     */
    public function logoutOtherDevices(): int
    {
        return App::make(LoginTracker::class)->logoutOthers($this);
    }

    /**
     * بررسی آیا کاربر با سشن احراز هویت شده است
     *
     * @return bool
     */
    public function isAuthenticatedBySession(): bool
    {
        return session()->isStarted() && auth()->check() && auth()->user()->getKey() == $this->getKey();
    }

    /**
     * بررسی آیا کاربر با توکن احراز هویت شده است
     *
     * @return bool
     */
    public function isAuthenticatedByToken(): bool
    {
        // بررسی سنکتوم
        if (method_exists($this, 'currentAccessToken') && $this->currentAccessToken()) {
            return true;
        }

        return false;
    }

    /**
     * Get the "remember me" token value.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}

<?php

namespace App\Models;

use App\Services\LoginSecurity\LoginTracker;
use App\Traits\HasMorphAlias;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Modules\ActivityLog\App\Models\ActivityLog;

class LoginTracking extends Model
{
    use HasFactory, SoftDeletes, HasMorphAlias;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public static string $morphClass;


    protected $fillable = [
        'user_type',
        'user_id',
        'enter_with', // اضافه شد
        'session_id',
        'token_id',
        'device_name',
        'device_type',
        'browser',
        'platform',
        'ip_address',
        'user_agent',
        'device_fingerprint',
        'location_data',
        'remember_token',
        'last_activity_at',
        'is_suspicious',
        'security_alerts',
        'expires_at',
        'revoke_by' , // اضافه شد
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'session_id',
        'token_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'device_fingerprint' => 'array',
        'location_data' => 'array',
        'security_alerts' => 'array',
        'last_activity_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_suspicious' => 'boolean',
    ];

    /**
     * تعریف رابطه یک-به-چند با لاگ‌های فعالیت.
     * هر نشست می‌تواند فعالیت‌های زیادی داشته باشد.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
    /**
     * ارتباط با کاربر
     */
    public function user(): MorphTo
    {
        return $this->morphTo('user');
    }

    /**
     * آیا این لاگین فعلی است
     *
     * @return bool
     */
    public function getIsCurrentAttribute(): bool
    {
        // بررسی لاگین با سشن
        if ($this->session_id && Session::getId() && $this->session_id === Session::getId()) {
            return true;
        }

        // بررسی لاگین با توکن API (سنکتوم)
        if ($this->token_id && optional(request()->user())->currentAccessToken()) {
            return $this->token_id == request()->user()->currentAccessToken()->id;
        }

        return false;
    }

    /**
     * نمایش بهتر آخرین فعالیت
     */
    public function getLastActiveHumanAttribute(): string
    {
        if ($this->last_activity_at) {
            return $this->last_activity_at->diffForHumans();
        }

        return $this->created_at->diffForHumans();
    }

    /**
     * ابطال و حذف این لاگین
     *
     * @return bool
     */
    public function revoke(string $revoke_by = 'own',?string $reason = null): bool
    {

        if ($this->remember_token){
            app(LoginTracker::class)->storeInvalidatedToken($this->remember_token,$this->user_id,'revoke');
        }
        $revoke_by = [
            'type' => $revoke_by,
            'id' => auth()?->id() ?? null
        ];

        if ($revoke_by['type'] === 'own') {
            unset($revoke_by['id']);
        }
        if ($reason){
            $revoke_by['reason'] = $reason;
        }


        $this->update([
            'remember_token' => null, // حذف remember token
            'revoke_by' => $revoke_by, // حذف کننده کی بوده
        ]);


        if ($this->token_id) {
            // حذف توکن API
            \DB::table('personal_access_tokens')
                ->where('id', $this->token_id)
                ->delete();
        }

        // حذف ردیف از دیتابیس
        return (bool)$this->delete();
    }

    /**
     * به‌روزرسانی زمان آخرین فعالیت
     */
    public function updateLastActivity(): void
    {
        $this->update([
            'last_activity_at' => Carbon::now(),
        ]);
    }

    /**
     * افزودن هشدار امنیتی به این لاگین
     *
     * @param string $type نوع هشدار
     * @param array $data داده‌های مرتبط
     * @return void
     */
    public function addSecurityAlert(string $type, array $data = [],$charged = true): void
    {
        $alerts = $this->security_alerts ?? [];

        $alerts[] = [
            'type' => $type,
            'data' => $data,
            'timestamp' => Carbon::now()->toIso8601String(),
        ];

        $this->security_alerts = $alerts;
        if ($charged){
            $this->is_suspicious = true;
        }

        $this->save();
    }

    /**
     * تنظیم کردن مشخصات دستگاه
     *
     * @param string $userAgent
     * @return void
     */
    public function setDeviceInfo(string $userAgent)//: void
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $this->device_type = $agent->isDesktop() ? 'desktop' :
            ($agent->isTablet() ? 'tablet' :
                ($agent->isMobile() ? 'mobile' : 'other'));

        $this->browser = $agent->browser();
        $this->platform = $agent->platform();
        $this->device_name = $agent->device();


        $this->save();
    }
}

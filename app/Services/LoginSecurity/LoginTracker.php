<?php

namespace App\Services\LoginSecurity;


use App\facade\BaseQuery\BaseQuery;
use App\facade\Module\ModuleFacade;
use App\facade\Notification\Notification;
use App\Models\AdminAllert;
use App\Models\LoginTracking;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\User\App\Models\User;
use Modules\User\App\Models\UserAllert;


class LoginTracker
{

    /**
     * برای این که متوجه بشیم از طریق توکن برگشتی داره کاربر رو میخونه
     */
    public $retrivedTrack = null;


    public $enter_with = null; //    در زمان ورودش تنظیم میشود

    /**
     * بعد زاز برگردوندن توکن قدیمی رو سیو میکنیم
     */
    public $old_remember_token = null;
    public $remember_token = null;
    /**
     * برای این که متوجه بشیم از طریق توکن برگشتی داره کاربر رو میخونه
     * تنظیمات
     */
    protected array $config = [];

    /**
     * تنظیمات Token History
     */
    protected array $tokenHistoryConfig = [
        'cache_ttl' => 60 * 60 * 24 * 30, // 30 روز
        'max_history_per_user' => 100,
    ];

    /**
     * لاگین فعلی
     */
    protected ?LoginTracking $currentLogin = null;

    /**
     * سازنده کلاس
     */
    public function __construct(array $config = [])
    {
        \Illuminate\Log\log('logintrcaker');
        $this->config = array_merge($this->config, $config);
    }

    /**
     * ثبت یک لاگین جدید
     * @param Authenticatable $user کاربر
     * @param bool $remember آیا گزینه "مرا به خاطر بسپار" فعال است؟
     * @return LoginTracking
     */
    public function track(Authenticatable $user, bool $remember = false): LoginTracking
    {

        $loginId = $this->retrivedTrack;

        return $loginId ? $this->updateTrack($loginId, $user) : $this->makeTrack($user, $remember);

    }

    /**
     * ثبت یک لاگین جدید
     * @param Authenticatable $user کاربر
     * @param bool $remember آیا گزینه "مرا به خاطر بسپار" فعال است؟
     * @return LoginTracking
     */
    public function updateTrack(LoginTracking $login, Authenticatable $user): LoginTracking
    {

        // در login_trackings به‌روز کن
        $login->session_id = \session()->id();
        $login->remember_token = $this->remember_token;
        $login->save();

        //ثبت کردن توکن قدیمی در کش
        $this->storeInvalidatedToken($this->old_remember_token, $user->getKey(), 'remembered');
        // کوکی جدید queue کن
        $this->queueNewRememberCookie($user, $this->remember_token);
        // بررسی و پاکسازی لاگین‌های قدیمی
        $this->cleanupOldSessions($user);
        // بررسی فعالیت مشکوک
//        $this->checkForSuspiciousActivity($user, $login);

        $this->currentLogin = $login;


        return $login;


    }

    /**
     * ثبت یک لاگین جدید
     * @param Authenticatable $user کاربر
     * @param bool $remember آیا گزینه "مرا به خاطر بسپار" فعال است؟
     * @return LoginTracking
     */
    public function makeTrack(Authenticatable $user, bool $remember = false): LoginTracking
    {
        $login = new LoginTracking();
        $login->user_type = BaseQuery::morphAlias($user);
        $login->user_id = $user->getKey();
        $login->ip_address = Request::ip();
        $login->user_agent = Request::header('User-Agent');
        $login->session_id = Session::getId();
        $login->last_activity_at = Carbon::now();
        $login->expires_at = Carbon::now()->addDays($this->config['expires_in_days']);

        // اگر گزینه "مرا به خاطر بسپار" فعال باشد، توکن ایجاد می‌کنیم
        Log::info('Remember Me', [
            'Remember' => $this->remember_token,
            'all' => \session()->all(),

        ]);
        if ($remember) {
            Log::info('Remember Me on make track', [$this->remember_token]);
            $login->remember_token = $this->remember_token;
        }
        //اگر نحوه ورود از قبل مشخص شده باشد ثبت میشود
        if ($this->enter_with) {
            $login->enter_with = $this->enter_with;
        }
        // تنظیم اطلاعات دستگاه
        if (!empty($login->user_agent)) {
            $login->setDeviceInfo($login->user_agent);
        }

        // اطلاعات اثر انگشت دستگاه

        if ($this->config['fingerprint_level'] !== 'none') {

            $login->device_fingerprint = $this->captureDeviceFingerprint();

        }
        // اطلاعات موقعیت جغرافیایی
        if ($this->config['geolocation_enabled']) {
            $login->location_data = $this->getLocationData($login->ip_address);
        }

        $login->save();

        // بررسی و پاکسازی لاگین‌های قدیمی
        $this->cleanupOldSessions($user);

        // بررسی فعالیت مشکوک
//        $this->checkForSuspiciousActivity($user, $login);

        $this->currentLogin = $login;

        return $login;

    }


    /**
     * اجرای اقدام امنیتی اجباری بر اساس سطح تهدید
     * @param string $level سطح امنیت: 'hard', 'medium', 'easy'
     * @param string $reason دلیل اقدام امنیتی
     * @param array $details جزئیات اضافی
     * @param Authenticatable|null $user کاربر (اختیاری)
     * @return void
     */
    public function forceSecurityAction(string $level, string $reason, array $details = [], ?Authenticatable $user = null, ?LoginTracking $login = null, null|object $rememberInfo = null): void
    {

        $user = $user ?? Auth::user();

        if (!$user) {
            Log::warning('Security action attempted without user context', [
                'level' => $level,
                'reason' => $reason,
                'details' => $details,
                'ip' => Request::ip()
            ]);
            return;
        }

        $securityData = [
            'user_id' => $user->getKey(),
            'user_type' => $user->morph_class,
            'level' => $level,
            'reason' => $reason,
            'details' => $details,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'timestamp' => Carbon::now()->toIso8601String(),
            'session_id' => Session::getId(),
        ];

        switch ($level) {
            case 'hard':
                $this->executeHardSecurityAction($user, $reason, $securityData, $login);
                break;

            case 'medium':
                $this->executeMediumSecurityAction($user, $reason, $securityData, $login);
                break;

            case 'easy':
                $this->executeEasySecurityAction($user, $reason, $securityData, $login);
                break;

            default:
                Log::error('Invalid security action level', $securityData);
        }
    }


    /**
     * اجرای اقدام امنیتی سطح بالا (Hard)
     */
    protected function executeHardSecurityAction(Authenticatable $user, string $reason, array $securityData, ?LoginTracking $login = null): void
    {
        // 1. 🔥 سوزاندن تمام Login Trackings
        $allLogins = LoginTracking::where('user_type', BaseQuery::morphAlias($user))
            ->where('user_id', $user->getKey())
            ->get();

        foreach ($allLogins as $login) {

            $login->addSecurityAlert($reason, [
                'terminated_by' => 'security_system',
                'details' => $securityData['details'],
                'security_data' => $securityData
            ], false);
            $login->revoke('securitu_system');
        }
        // 2. 🚨 قرنطینه کاربر + اطلاع به کاربر
        UserAllert::query()->create([
            'user_id' => $user->id,
            'content' => 'You have been quarantined! For enhanced security, please log in to the site again.',
            'type' => 'danger'
        ]);
        $user->update(['status' => 'quarantined']);

        // 3. 📝 ثبت لاگ بحرانی
        ModuleFacade::logIfAvailable(
            level: 'critical',
            subject: $user,
            event: 'revoke',
            description: $reason,
            logName: 'auth',
            causer: 'security_system',
            properties: $securityData['details']
        );


        // 4. 🔔 اطلاع‌رسانی به تیم امنیت

        AdminAllert::query()->create([
            'content' => 'A malicious authentication attempt has occurred!',
            'type' => 'danger'
        ]);

    }

    /**
     * اجرای اقدام امنیتی سطح متوسط (Medium)
     */
    protected function executeMediumSecurityAction(Authenticatable $user, string $reason, array $securityData, ?LoginTracking $login = null): void
    {

        if ($login) {

            $login->addSecurityAlert($reason, [
                'terminated_by' => 'security_system',
                'details' => $securityData['details'],
                'security_data' => $securityData
            ]);

            $login->revoke('securitu_system');
        }

        // 2. ⚠️ اخطار به کاربر
        UserAllert::query()->create([
            'user_id' => $user->id,
            'content' => 'You have been quarantined! For your security, please log in to the site again.',
            'type' => 'warning'
        ]);

        // 3. 📝 ثبت لاگ
        ModuleFacade::logIfAvailable(
            level: 'warning',
            subject: $user,
            event: 'revoke',
            description: $reason,
            logName: 'auth',
            causer: 'security_system',
            properties: $securityData['details']
        );

        // 4. 🔔 اطلاع‌رسانی به تیم امنیت

        AdminAllert::query()->create([
            'content' => 'A malicious authentication attempt has occurred! Check the logs immediately.',
            'type' => 'warning'
        ]);

    }

    /**
     * اجرای اقدام امنیتی سطح پایین (Easy)
     */
    protected function executeEasySecurityAction(Authenticatable $user, string $reason, array $securityData, ?LoginTracking $login = null): void
    {


        if ($login) {
            $login->addSecurityAlert($reason, [
                'action' => 'warning_only',
                'details' => $securityData['details'],
                'security_data' => $securityData
            ]);
        }


        // 3. 📝 ثبت لاگ
        ModuleFacade::logIfAvailable(
            level: 'notice',
            subject: $user,
            event: 'revoke',
            description: $reason,
            logName: 'auth',
            causer: 'security_system',
            properties: $securityData['details']
        );

        // 3. 🔔 اطلاع‌رسانی به کاربر
        UserAllert::query()->create([
            'user_id' => $user->id,
            'content' => 'Suspicious activity on your account was blocked. Please stay alert. 🌹🌹',
            'type' => 'warning'
        ]);

    }


    /**
     * بارگذاری لاگین فعلی
     * @param Authenticatable|null $user کاربر
     * @return LoginTracking|null
     */
    public function loadCurrentLogin(?Authenticatable $user = null): ?LoginTracking
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return null;
        }

        // اگر قبلاً لود شده، از همان استفاده کن
        if ($this->currentLogin) {
            return $this->currentLogin;
        }


        // بررسی سشن
        if (Session::isStarted()) {
            $this->currentLogin = LoginTracking::where('user_type', BaseQuery::morphAlias($user))
                ->where('user_id', $user->getKey())
                ->where('session_id', Session::getId())
                ->where('expires_at', '>', now())
                ->first();

            if ($this->currentLogin) {
                return $this->verifyLoginSecurity($this->currentLogin) ? $this->currentLogin : null;
            }
        }


        return null;
    }

    /**
     * بررسی امنیتی لاگین
     * @param LoginTracking $login
     * @return bool
     */
    public function verifyLoginSecurity(LoginTracking $login, $revokeOnSense = true): bool
    {
        $isSecure = true;

        // بررسی IP
        if ($this->config['ip_security'] && !empty($login->ip_address) && $login->ip_address !== Request::ip()) {

            $charged = $this->config['strict_remember_me_ip'] ?? false;

            if ($charged) {
                $isSecure = false;
            } else {
                $login->setDeviceInfo(Request::ip());
            }

            $this->handleSecurityBreach($login, 'ip_change', [
                'old_ip' => $login->ip_address,
                'new_ip' => $charged ? Request::ip() : $login->ip_address = Request::ip(),
            ], $charged);

        }

        // بررسی User-Agent
        if ($this->config['user_agent_security'] && !empty($login->user_agent) && $login->user_agent !== Request::header('User-Agent')) {

            $charged = $this->config['strict_remember_me_ua'] ?? true;

            if ($charged) {
                $isSecure = false;
            } else {
                $login->setDeviceInfo(Request::header('User-Agent'));
            }


            $this->handleSecurityBreach($login, 'user_agent_mismatch', [
                'old_user_agent' => $login->user_agent,
                'new_user_agent' => $charged ? Request::header('User-Agent') : $login->user_agent = Request::header('User-Agent'),
            ], $charged);


        }

        // بررسی اثر انگشت دستگاه در سطوح بالای امنیتی
        if ($this->config['fingerprint_level'] !== 'none') {
            $currentFingerprint = $this->captureDeviceFingerprint();
            $similarity = $this->calculateFingerprintSimilarity($login->device_fingerprint, $currentFingerprint);

            $requiredSimilarity = match ($this->config['fingerprint_level']) {
                'high' => 0.9,    // 90% تطابق
                'medium' => 0.75, // 75% تطابق
                'basic' => 0.5,   // 50% تطابق
                default => 0,
            };

            if ($similarity < $requiredSimilarity) {
                $this->handleSecurityBreach($login, 'fingerprint_mismatch', [
                    'similarity' => $similarity,
                    'required' => $requiredSimilarity,
                ]);

                $isSecure = false;
            }
        }


        // به‌روزرسانی زمان آخرین فعالیت
        $login->updateLastActivity();

        if (!$isSecure and $revokeOnSense) {
            $login->revoke('securitu_system');
        }

        return $isSecure;
    }


    /**
     * مدیریت نقض امنیت
     * @param LoginTracking $login
     * @param string $breachType
     * @param array $data
     */
    public function handleSecurityBreach(LoginTracking $login, string $breachType, array $data = [], $charged = true): void
    {

        // 1. 🔔 Notify the user
        UserAllert::query()->create([
            'user_id' => $login->user_id,
            'content' => 'Some of your sessions have been blocked by the security system. You have not been logged out, but it is recommended to review your sessions and make changes if necessary.',
            'type' => 'warning'
        ]);

// 2. 🔔 Notify the security team
        AdminAllert::query()->create([
            'content' => 'A malicious authentication attempt has occurred! Check the logs immediately.',
            'type' => 'warning'
        ]);


        // 3. 📝 ثبت لاگ
        ModuleFacade::logIfAvailable(
            level: 'notice',
            subject: $login,
            event: 'revoke',
            description: $breachType,
            logName: 'auth',
            causer: 'security_system',
            properties: $data
        );

        $login->addSecurityAlert($breachType, $data, $charged);

    }


    /**
     * سبک لاگین سفارشی
     *
     * @param Authenticatable $user کاربر
     * @param bool $remember آیا گزینه "مرا به خاطر بسپار" فعال است؟
     *
     */
    public function customLogin(Authenticatable $user, bool $remember = false, string $enter_with = null)
    {

        $this->enter_with = $enter_with;

        return auth()->loginUsingId($user->id, true);


    }

    /**
     * باطل کردن توکن فعلی و ذخیره در تاریخچه
     * ذخیره توکن‌های باطل شده در کش
     */
    public function storeInvalidatedToken(string $token, int $userId, string $reason = null): void
    {
        if (empty($token)) return;

        $key = "invalid_tokens:{$userId}";

        // اضافه کردن توکن به لیست باطل‌شده‌ها
        Cache::remember($key, $this->tokenHistoryConfig['cache_ttl'], function () {
            return [];
        });

        $invalidTokens = Cache::get($key, []);

        $info = [
            'token' => Hash::make($token), // هش شده برای امنیت
            'invalidated_at' => Carbon::now()->toIso8601String(),
        ];

        if ($reason) {
            $info['reason'] = $reason;
        }

        $invalidTokens[] = $info;
        // نگه داشتن حداکثر 50 توکن آخر
        if (count($invalidTokens) > $this->tokenHistoryConfig['max_history_per_user']) {
            $invalidTokens = array_slice($invalidTokens, -$this->tokenHistoryConfig['max_history_per_user']);
        }

        Cache::put($key, $invalidTokens, $this->tokenHistoryConfig['cache_ttl']); // 24 ساعت
    }

    /**
     * بررسی اینکه آیا توکن قبلاً باطل شده
     */
    public function isTokenInvalidated(string $token, int $userId): bool|array
    {
        if (empty($token)) return false;

        $key = "invalid_tokens:{$userId}";
        $invalidTokens = Cache::get($key, []);

        foreach ($invalidTokens as $invalidToken) {
            if (Hash::check($token, $invalidToken['token'])) {
                return $invalidToken;
            }
        }


        return false;
    }


    /**
     * ثبت یک لاگین با توکن API
     * @param Authenticatable $user کاربر
     * @param string $tokenId شناسه توکن API
     * @return LoginTracking
     */
    public function trackApiToken(Authenticatable $user, string $tokenId) //: LoginTracking
    {

//        // ایجاد یک لاگین جدید
//        $login = new LoginTracking();
//        $login->user_type = get_class($user);
//        $login->user_id = $user->getKey();
//        $login->ip_address = Request::ip();
//        $login->user_agent = Request::header('User-Agent'); // todo در مایگریشن 512 کرکتر باشه و حتما
//        $login->token_id = $tokenId;
//        $login->last_activity_at = Carbon::now();
//
//        // تنظیم اطلاعات دستگاه
//        if (!empty($login->user_agent)) {
//            $login->setDeviceInfo($login->user_agent);
//        }
//
//        // اطلاعات اثر انگشت دستگاه
//        $login->device_fingerprint = $this->captureDeviceFingerprint();
//
//        // اطلاعات موقعیت جغرافیایی
//        if ($this->config['geolocation_enabled']) {
//            $login->location_data = $this->getLocationData($login->ip_address);
//        }
//
//        $login->save();
//
//        // بررسی فعالیت مشکوک
//        $this->checkForSuspiciousActivity($user, $login);
//
//        return $login;
    }


    /**
     * انجام Token Rotation دستی
     */
    public function performTokenRotation($user, $login, $oldToken): void
    {
        // توکن جدید بساز
        $newToken = \Illuminate\Support\Str::random(60);

        $this->remember_token = $newToken;
        $this->retrivedTrack = $login;
        $this->old_remember_token = $oldToken;

    }

    protected function queueNewRememberCookie($user, $token): void
    {
        $value = $user->getAuthIdentifier() . '|' . $token . '|' . $user->getAuthPassword();

        $guard = Auth::guard('web');
        $cookieName = $guard->getRecallerName();

        $minutes = config('login-security.expires_in_days', 30) * 24 * 60;

        Cookie::queue(
            $cookieName,
            $value,
            $minutes,
            '/',
            null,
            true, // secure
            true  // httpOnly
        );
    }




    /**
     * خارج کردن همه لاگین‌های دیگر یک کاربر بجز لاگین فعلی
     * @param Authenticatable $user
     * @return int تعداد لاگین‌هایی که حذف شده‌اند
     */
    public function logoutOthers(Authenticatable $user): int
    {
        $currentLogin = $this->loadCurrentLogin($user);

        if (!$currentLogin) {
            return 0;
        }

        $query = LoginTracking::where('user_type', BaseQuery::morphAlias($user))
            ->where('user_id', $user->getKey());

        if ($currentLogin->session_id) {
            $query->where(function ($q) use ($currentLogin) {
                $q->where('session_id', '!=', $currentLogin->session_id)
                    ->orWhereNull('session_id');
            });
        } elseif ($currentLogin->token_id) {
            $query->where(function ($q) use ($currentLogin) {
                $q->where('token_id', '!=', $currentLogin->token_id)
                    ->orWhereNull('token_id');
            });
        }

        $logins = $query->get();

        $count = 0;
        foreach ($logins as $login) {
            if ($login->revoke()) {
                $count++;
            }
        }

        return $count;
    }


    /**
     * تمیز کردن لاگین‌های قدیمی کاربر
     * @param Authenticatable $user
     */
    protected function cleanupOldSessions(Authenticatable $user): void
    {
        // حذف لاگین‌های منقضی شده
        LoginTracking::where('user_type', BaseQuery::morphAlias($user))
            ->where('user_id', $user->getKey())
            ->where('expires_at', '<', Carbon::now())
            ->delete();

        // اگر محدودیت تعداد سشن وجود دارد، قدیمی‌ترین‌ها را حذف کن
        if ($this->config['max_sessions_per_user'] > 0 && !$this->config['allow_multiple_sessions']) {
            $activeSessions = LoginTracking::where('user_type', BaseQuery::morphAlias($user))
                ->where('user_id', $user->getKey())
                ->orderByDesc('last_activity_at')
                ->get();

            if ($activeSessions->count() > $this->config['max_sessions_per_user']) {
                // نگه داشتن جدیدترین سشن‌ها و حذف بقیه
                \Illuminate\Log\log('omadam login ha ro pak konam', [
                    $activeSessions->count(),
                    $activeSessions->skip($this->config['max_sessions_per_user']),
                    $activeSessions

                ]);
                // تست شده ✅
                foreach ($activeSessions->skip($this->config['max_sessions_per_user']) as $oldSession) {
                    $oldSession->revoke('securitu_system', 'max_user');
                }
            }
        }
    }


    /**
     * بررسی فعالیت مشکوک برای لاگین جدید
     *
     * @param Authenticatable $user
     * @param LoginTracking $newLogin
     */
    protected function checkForSuspiciousActivity(Authenticatable $user, LoginTracking $newLogin): void
    {
        // بررسی لاگین‌های قبلی
        $previousLogins = LoginTracking::where('user_type', BaseQuery::morphAlias($user))
            ->where('user_id', $user->getKey())
            ->where('id', '!=', $newLogin->id)
            ->orderByDesc('last_activity_at')
            ->limit(5)
            ->get();

        if ($previousLogins->isEmpty()) {
            // اولین لاگین است، چیز مشکوکی نیست
            return;
        }

        $isSuspicious = false;
        $suspiciousReasons = [];

        $lastLogin = $previousLogins->first();

        // تغییر IP
        if (!empty($lastLogin->ip_address) && $lastLogin->ip_address !== $newLogin->ip_address) {
            // بررسی لاگین از محل جغرافیایی متفاوت
            if (!empty($lastLogin->location_data) && !empty($newLogin->location_data)) {
                if ($lastLogin->location_data['countryCode'] !== $newLogin->location_data['countryCode']) {
                    // تغییر کشور - بسیار مشکوک
                    $isSuspicious = true;
                    $suspiciousReasons[] = 'country_change';

                    // بررسی فاصله زمانی لاگین از دو کشور مختلف
                    $timeDiffHours = $newLogin->created_at->diffInHours($lastLogin->last_activity_at);

                    if ($timeDiffHours < 24) {
                        // ورود از دو کشور مختلف در کمتر از 24 ساعت، بسیار مشکوک است
                        $suspiciousReasons[] = 'impossible_travel';
                    }
                }
            }
        }

        // تغییر دستگاه
        if (!empty($lastLogin->device_type) && !empty($newLogin->device_type) && $lastLogin->device_type !== $newLogin->device_type) {
            // تغییر نوع دستگاه - مشکوک کم
            $suspiciousReasons[] = 'device_type_change';
        }

        if (!empty($lastLogin->browser) && !empty($newLogin->browser) && $lastLogin->browser !== $newLogin->browser) {
            // تغییر مرورگر - مشکوک کم
            $suspiciousReasons[] = 'browser_change';
        }

        if (!empty($lastLogin->platform) && !empty($newLogin->platform) && $lastLogin->platform !== $newLogin->platform) {
            // تغییر سیستم عامل - مشکوک متوسط
            $suspiciousReasons[] = 'os_change';
            $isSuspicious = true;
        }

        // اگر فعالیت مشکوک است، آن را ثبت کن
        if ($isSuspicious || !empty($suspiciousReasons)) {
            $newLogin->is_suspicious = $isSuspicious;
            $newLogin->addSecurityAlert('suspicious_login', [
                'reasons' => $suspiciousReasons,
                'last_login' => [
                    'id' => $lastLogin->id,
                    'ip' => $lastLogin->ip_address,
                    'location' => $lastLogin->location_data,
                    'device' => $lastLogin->device_type,
                    'browser' => $lastLogin->browser,
                    'platform' => $lastLogin->platform,
                    'time' => $lastLogin->last_activity_at->toIso8601String(),
                ]
            ]);

            //  todo ارسال رویداد برای اطلاع‌رسانی

        }
    }


    /**
     * دریافت اطلاعات موقعیت جغرافیایی بر اساس IP
     * @param string $ip
     * @return array|null
     */
    protected function getLocationData(string $ip): ?array
    {
        try {
            $location = Location::get($ip);

            if ($location) {
                return [
                    'ip' => $ip,
                    'countryName' => $location->countryName,
                    'countryCode' => $location->countryCode,
                    'regionCode' => $location->regionCode,
                    'regionName' => $location->regionName,
                    'cityName' => $location->cityName,
                    'zipCode' => $location->zipCode,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'timezone' => $location->timezone,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch IP geolocation information', [
                'ip' => $ip,
                'error' => $e->getMessage(),
            ]);

        }

        return null;
    }

    /**
     * جمع‌آوری اطلاعات اثر انگشت دستگاه
     *
     * @return array
     */
    protected function captureDeviceFingerprint(): array
    {
        $fingerprint = [
            'ip' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ];

        // دریافت اطلاعات از هدرهای HTTP
        $headers = [
            'accept',
            'accept-charset',
            'accept-encoding',
            'accept-language',
        ];

        foreach ($headers as $header) {
            $fingerprint['headers'][$header] = Request::header($header);
        }

        // اطلاعات کوکی‌های fingerprint
        $fingerprint_cookie = Request::cookie('device_fingerprint');
        if ($fingerprint_cookie) {
            $fingerprint['cookie'] = $fingerprint_cookie;
        } else {
            // ایجاد کوکی جدید برای دفعات بعدی
            $newFingerprint = Str::random(40);
            Cookie::queue('device_fingerprint', $newFingerprint, 43200); // 30 روز
            $fingerprint['cookie'] = $newFingerprint;
        }

        return $fingerprint;
    }

    /**
     * محاسبه میزان شباهت بین دو اثر انگشت
     *
     * @param array|null $fingerprint1
     * @param array|null $fingerprint2
     * @return float 0-1
     */
    protected function calculateFingerprintSimilarity(?array $fingerprint1, ?array $fingerprint2): float
    {
        if (!$fingerprint1 || !$fingerprint2) {
            return 0;
        }

        $totalWeight = 0;
        $matchWeight = 0;

        // بررسی کوکی (وزن: 50)
        if (isset($fingerprint1['cookie']) && isset($fingerprint2['cookie'])) {
            $totalWeight += 50;
            if ($fingerprint1['cookie'] === $fingerprint2['cookie']) {
                $matchWeight += 50;
            }
        }

        // بررسی User-Agent (وزن: 25)
        if (isset($fingerprint1['user_agent']) && isset($fingerprint2['user_agent'])) {
            $totalWeight += 25;
            if ($fingerprint1['user_agent'] === $fingerprint2['user_agent']) {
                $matchWeight += 25;
            }
        }

        // بررسی IP (وزن: 15)
        if (isset($fingerprint1['ip']) && isset($fingerprint2['ip'])) {
            $totalWeight += 15;
            if ($fingerprint1['ip'] === $fingerprint2['ip']) {
                $matchWeight += 15;
            } else {
                // اگر فقط بخش‌های اصلی IP یکسان هستند (شبکه یکسان)
                $ip1Parts = explode('.', $fingerprint1['ip']);
                $ip2Parts = explode('.', $fingerprint2['ip']);

                if (count($ip1Parts) >= 2 && count($ip2Parts) >= 2 && $ip1Parts[0] === $ip2Parts[0] && $ip1Parts[1] === $ip2Parts[1]) {
                    $matchWeight += 8; // نیمی از وزن IP
                }
            }
        }

        // بررسی headers (وزن: 10)
        if (isset($fingerprint1['headers']) && isset($fingerprint2['headers'])) {
            $totalWeight += 10;
            $headerSimilarity = 0;
            $headerCount = 0;

            foreach ($fingerprint1['headers'] as $key => $value) {
                if (isset($fingerprint2['headers'][$key])) {
                    $headerCount++;
                    if ($fingerprint2['headers'][$key] === $value) {
                        $headerSimilarity++;
                    }
                }
            }

            if ($headerCount > 0) {
                $matchWeight += ($headerSimilarity / $headerCount) * 10;
            }
        }

        // جلوگیری از تقسیم بر صفر
        if ($totalWeight === 0) {
            return 0;
        }

        return $matchWeight / $totalWeight;
    }


    /**
     * تنظیم کانفیگ سرویس
     *
     * @param array $config
     * @return self
     */
    public function setConfig(array $config): self
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }
}

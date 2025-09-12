# سرویس امنیت لاگین

این سرویس برای ردیابی و مدیریت لاگین‌های کاربران طراحی شده است و امکانات زیر را فراهم می‌کند:

- ردیابی هر لاگین با اطلاعات کامل دستگاه (نوع دستگاه، نام دستگاه، سیستم عامل، مرورگر، آدرس IP)
- ذخیره این اطلاعات در پایگاه داده، امکان نمایش به کاربران در حساب کاربری آنها
- اطلاع‌رسانی به کاربران در مورد لاگین‌های جدید، همراه با اطلاعات جمع‌آوری شده
- امکان خروج از یک دستگاه خاص، همه دستگاه‌ها به جز دستگاه فعلی، یا همه دستگاه‌ها
- خروج از هر دستگاه خاص، بدون تأثیر بر سایر دستگاه‌های وارد شده (هر نشست دارای توکن مخصوص به خود است)
- امکان ردیابی توکن‌های دسترسی Sanctum، مفید برای احراز هویت برنامه‌های موبایل
- شناسایی فعالیت‌های مشکوک و اطلاع‌رسانی به کاربر
- اثر انگشت دستگاه برای شناسایی دقیق‌تر و افزایش امنیت

## نحوه استفاده

### آماده‌سازی مدل‌های احراز هویت

برای ردیابی لاگین کاربران، تریت `HasLoginTracking` را به مدل‌هایی که می‌خواهید ردیابی شوند، اضافه کنید:

```php
use App\Traits\HasLoginTracking;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasLoginTracking;

    // ...
}
```

### تنظیم گارد احراز هویت

برای استفاده از قابلیت‌های امنیتی سرویس، باید گارد امنیتی سفارشی را در تنظیمات `auth.php` خود تنظیم کنید:

```php
'guards' => [
    'web' => [
        'driver' => 'login-security',
        'provider' => 'users',
    ],
    
    // ...
],
```

### تنظیم پرووایدر کاربر

پرووایدر کاربر را نیز در فایل `auth.php` تنظیم کنید:

```php
'providers' => [
    'users' => [
        'driver' => 'login-security',
        'model' => App\Models\User::class,
    ],
    
    // ...
],
```

### ثبت سرویس پرووایدر

سرویس پرووایدر را در `config/app.php` ثبت کنید:

```php
'providers' => [
    // ...
    App\Providers\LoginSecurityServiceProvider::class,
],
```

### انتشار تنظیمات

فایل تنظیمات را منتشر کنید:

```bash
php artisan vendor:publish --tag="login-security-config"
```

## استفاده از API سرویس

تریت `HasLoginTracking` متدهای زیر را به مدل کاربر شما اضافه می‌کند:

### دریافت لاگین‌ها

```php
// دریافت همه لاگین‌ها
$logins = auth()->user()->loginTrackings;

// دریافت لاگین فعلی
$currentLogin = auth()->user()->current_login;
```

### خروج از دستگاه‌ها

```php
// خروج از یک دستگاه خاص
auth()->user()->logoutDevice(1); // خروج از دستگاه با شناسه 1

// خروج از همه دستگاه‌ها
auth()->user()->logoutAllDevices();

// خروج از همه دستگاه‌ها به جز دستگاه فعلی
auth()->user()->logoutOtherDevices();
```

## تنظیمات پیشرفته

می‌توانید تنظیمات سرویس را در فایل `config/login-security.php` تغییر دهید.

## پاکسازی خودکار

برای پاکسازی خودکار لاگین‌های منقضی شده، دستور زیر را به Scheduler خود اضافه کنید:

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('login-security:cleanup')->daily();
}
```

## ساختار جدول دیتابیس

جدول `login_trackings` شامل فیلدهای زیر است:

- `id` - شناسه یکتا
- `user_type` - نوع مدل کاربر (برای ارتباط چند‌ریختی)
- `user_id` - شناسه کاربر
- `session_id` - شناسه نشست
- `token_id` - شناسه توکن API
- `device_name` - نام دستگاه
- `device_type` - نوع دستگاه (دسکتاپ، موبایل، تبلت)
- `browser` - مرورگر
- `platform` - سیستم عامل
- `ip_address` - آدرس IP
- `user_agent` - هدر User-Agent
- `device_fingerprint` - اطلاعات اثر انگشت دستگاه
- `location_data` - اطلاعات جغرافیایی
- `remember_token` - توکن "مرا به خاطر بسپار"
- `last_activity_at` - زمان آخرین فعالیت
- `is_suspicious` - آیا لاگین مشکوک است؟
- `security_alerts` - هشدارهای امنیتی
- `timestamps` - زمان ایجاد و بروزرسانی
- `deleted_at` - زمان حذف نرم
- `expires_at` - زمان انقضا 
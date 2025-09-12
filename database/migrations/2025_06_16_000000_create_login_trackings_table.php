<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('login_trackings', function (Blueprint $table) {
            $table->id();
            $table->morphs('user'); // پشتیبانی از چند نوع کاربر (user, admin, etc.)
            // ستونی برای مشخص کردن روش ورود کاربر (مثلاً google, sms, password)
            // این ستون بعد از ستون 'user_id' اضافه می‌شود تا ساختار منطقی باشد.
            $table->string('enter_with', 50)->nullable()->comment('Login method, e.g., password, google, sms, magic_link');
            $table->string('session_id')->nullable();
            $table->string('token_id')->nullable(); // برای توکن‌های API
            $table->string('device_name')->nullable();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser')->nullable();
            $table->string('platform')->nullable(); // OS
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('device_fingerprint')->nullable(); // اطلاعات اثرانگشت دستگاه
            $table->json('location_data')->nullable(); // اطلاعات جغرافیایی
            $table->string('remember_token')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->boolean('is_suspicious')->default(false); // نشانگر لاگین مشکوک
            $table->json('security_alerts')->nullable(); // هشدارهای امنیتی مرتبط با این لاگین
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('expires_at')->nullable();
            // ستونی برای ثبت اینکه چه کسی یا چه چیزی این نشست را خاتمه داده است.
            // می‌تواند یک شناسه کاربر، شناسه نشست دیگر، یا یک رشته مانند 'system' یا 'own' باشد.
            $table->string('deleted_by')->nullable()->comment("Who/what terminated the session, e.g., 'user:1', 'session:123', 'system', 'own'");

            // ایندکس‌های مهم برای عملکرد بهتر
            $table->index('session_id');
            $table->index('token_id');
//            $table->index(['user_type', 'user_id']);
            $table->index('ip_address');
            $table->index('last_activity_at');
            $table->index('expires_at');
            // ایندکس برای ستون جدید جهت جستجوی سریع‌تر
            $table->index('enter_with');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_trackings');
    }
};

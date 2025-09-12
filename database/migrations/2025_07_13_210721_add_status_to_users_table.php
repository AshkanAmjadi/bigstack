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
        Schema::table('users', function (Blueprint $table) {
            // مقادیر ممکن: active, inactive, quarantined, banned, pending_verification
            $table->string('status', 50)->default('active')->after('remember_token');

            // ایندکس‌گذاری روی ستون status برای سرعت در فیلتر کردن کاربران
            $table->index('status');
            // این تابع یک ستون timestamp به نام deleted_at ایجاد می‌کند که nullable است
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

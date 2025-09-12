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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            $table->string('log_name', 50)->nullable();           // دسته‌بندی لاگ‌ها
            $table->string('event', 50)->nullable();              // نوع عملیات (create/update/...)

            $table->string('level', 20)->default('info'); //سطح ارور

            $table->string('subject_type', 100);                  // مدل مرتبط
            $table->unsignedBigInteger('subject_id');             // آی‌دی مدل مرتبط

            $table->string('causer_type', 100)->nullable();       // عامل (کاربر یا سیستم)
            $table->unsignedBigInteger('causer_id')->nullable();
            // ایجاد یک ستون برای ارجاع به نشست (session) که باعث این فعالیت شده است.
            // این ستون می‌تواند nullable باشد چون برخی فعالیت‌ها ممکن است خارج از یک نشست کاربری باشند (مثلا از طریق یک job در صف).
            $table->unsignedBigInteger('login_tracking_id')->nullable();

            $table->json('properties')->nullable();               // جزئیات انعطاف‌پذیر (ip, browser, changes...)
            $table->string('batch_id', 36)->nullable();           // شناسه گروهی عملیات

            $table->timestamp('created_at')->useCurrent();

            // ایندکس‌ها برای سرعت جستجو
            $table->index(['log_name']);
            $table->index(['event']);
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
            $table->index(['batch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};

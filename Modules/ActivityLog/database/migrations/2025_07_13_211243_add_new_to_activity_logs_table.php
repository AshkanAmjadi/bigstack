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

        if (!Schema::hasColumn('activity_logs', 'login_tracking_id')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                // ایجاد یک ستون برای ارجاع به نشست (session) که باعث این فعالیت شده است.
                // این ستون می‌تواند nullable باشد چون برخی فعالیت‌ها ممکن است خارج از یک نشست کاربری باشند (مثلا از طریق یک job در صف).
                $table->unsignedBigInteger('login_tracking_id')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // جدول نقش‌ها
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // مثل: admin, editor, ...
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // جدول دسترسی‌ها (permissions)
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // مثل: edit-article, delete-user, ...
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Pivot نقش-کاربر با قید only
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->json('only')->nullable(); // قیدهای شرطی (مثلا فقط دسته خاص، یا فقط خودش)
            $table->unique(['role_id', 'user_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Pivot پرمیشن-نقش با قید only (اختیاری اگر خواستی به رول قید بدی)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->json('only')->nullable(); // اگر خواستی برای کل رول شرط بذاری
            $table->unique(['permission_id', 'role_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        // Pivot پرمیشن-کاربر با قید only (مستقیم به کاربر)
        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
            $table->json('only')->nullable();
            $table->unique(['permission_id', 'user_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};

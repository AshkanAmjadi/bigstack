<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('username',40)->unique()->nullable();
            $table->string('username_set',50)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('melicode')->unique()->nullable();
            $table->string('avatar',300)->nullable();
            $table->string('top_img',300)->nullable();
            $table->boolean('news')->default(false);
            $table->boolean('staff')->default(false);
            $table->boolean('boss')->default(false);
            $table->boolean('superuser')->default(false);
            $table->boolean('email_verify')->default(false);
            $table->boolean('by_phone')->default(false);
            $table->enum('gender',['man','woman','other'])->default('man');
            $table->string('day',2)->nullable();
            $table->string('month',2)->nullable();
            $table->string('year',4)->nullable();
            $table->text('about_me')->nullable();
            $table->tinyText('insta_id')->unique()->nullable();
            $table->rememberToken();
            $table->string('status', 50)->default('active');
            $table->string('added_by',150)->nullable();
            $table->string('updated_by',150)->nullable();
            $table->timestamps();
            $table->softDeletes();


            // ایندکس‌گذاری روی ستون status برای سرعت در فیلتر کردن کاربران
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

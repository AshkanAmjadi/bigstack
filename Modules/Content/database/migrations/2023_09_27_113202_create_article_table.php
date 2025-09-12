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
        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->string('page_title',600)->unique();
            $table->string('title',600);
            $table->string('meta_description',600)->nullable();
            $table->string('keyword',6000)->nullable();
            $table->string('slug',2000)->unique();
            $table->string('alt',600)->nullable();
            $table->string('caption',600)->nullable();
            $table->string('read_time',100);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('category')->onDelete('set null');
            $table->enum('level',['3','2','1','0'])->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('chosen')->default(false);
            $table->string('img',600)->nullable();
            $table->unsignedBigInteger('view')->default(0);
            $table->string('added_by',150);
            $table->string('updated_by',150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};

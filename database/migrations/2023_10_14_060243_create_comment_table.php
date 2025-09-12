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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type' ,100);
            $table->string('title',300)->nullable();
            $table->text('content');
            $table->boolean('new')->default(true);
            $table->boolean('active')->default(false);
            $table->enum('buy_suggest',['yes','no','none'])->nullable();
            $table->unsignedBigInteger('parent')->default('0');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

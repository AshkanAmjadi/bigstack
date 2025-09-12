<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 400)->unique();
            $table->string('slug', 600)->unique();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('active')->default(false);
            $table->boolean('new')->default(true);
            $table->boolean('has_best')->default(false);
            $table->boolean('private')->default(false);
            $table->string('mention', 500)->nullable();
            $table->unsignedBigInteger('view')->default(0);
            $table->string('added_by', 150);
            $table->string('updated_by', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};

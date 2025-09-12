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
        Schema::create('insta_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title',300)->unique();
            $table->text('caption');
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('category')->onDelete('cascade');
            $table->string('link' ,6000)->nullable();
            $table->string('img',200)->nullable();
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
        Schema::dropIfExists('insta_article');
    }
};

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
        Schema::create('article_list', function (Blueprint $table) {
            $table->id();
            $table->string('title',600)->unique();
            $table->string('slug',600)->unique();
            $table->string('page_title',600)->unique();
            $table->string('meta_description',600);
            $table->string('keyword',6000)->nullable();
            $table->string('articles',3000000)->unique();
            $table->string('mobile_banner',300)->nullable();
            $table->string('banner',300)->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('article_list');
    }
};

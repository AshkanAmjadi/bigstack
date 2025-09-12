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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('title',600)->unique();
            $table->string('banner',600)->nullable();
            $table->string('mobile_banner',600)->nullable();
            $table->string('slug',2000)->nullable();
            $table->string('img',600)->nullable();
            $table->string('page_title',600)->nullable();
            $table->string('meta_description',600)->nullable();
            $table->string('keyword',6000)->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('parent_id');
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
        Schema::dropIfExists('category');
    }
};

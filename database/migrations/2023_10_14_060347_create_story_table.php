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
        Schema::create('story', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->unique();
            $table->string('img',300)->nullable();
            $table->string('link' ,6000)->nullable();
            $table->string('added_by',150);
            $table->string('updated_by',150);
            $table->timestamps();
        });
        Schema::create('story_item', function (Blueprint $table) {
            $table->id();
            $table->string('src',200);
            $table->unsignedBigInteger('parent');
            $table->foreign('parent')->references('id')->on('story')->onDelete('cascade');
            $table->unsignedSmallInteger('length')->nullable();
            $table->string('link' ,6000)->nullable();
            $table->string('link_text' ,6000)->nullable();
            $table->enum('type',['image','video']);
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
        Schema::dropIfExists('story_item');
        Schema::dropIfExists('story');
    }
};

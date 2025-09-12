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
        Schema::create('tag', function (Blueprint $table) {
            $table->id();
            $table->string('name',250)->unique();
            $table->string('page_title',600)->unique()->nullable();
            $table->string('meta_description',600)->unique()->nullable();
            $table->string('keyword',6000)->nullable();
            $table->string('img',200)->nullable();
            $table->string('banner',200)->nullable();
            $table->string('mobile_banner',200)->nullable();
            $table->string('added_by',150);
            $table->unsignedBigInteger('view')->default(0);
            $table->boolean('searchable')->default(false);

            $table->string('updated_by',150);
            $table->timestamps();
        });


        Schema::create('taggable', function (Blueprint $table) {

            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
            $table->unsignedBigInteger('taggable_id');
            $table->string('taggable_type' ,100);
            $table->primary(['tag_id','taggable_id','taggable_type']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag');
        Schema::dropIfExists('taggable');
    }
};

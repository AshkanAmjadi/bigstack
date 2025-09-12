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
        Schema::create('list', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->nullable();
            $table->string('icon',100)->nullable();
            $table->string('dark_icon',100)->nullable();
            $table->string('type',20)->nullable();
            $table->unsignedBigInteger('parent_id')->default('0');
            $table->unsignedBigInteger('listable_id')->nullable();
            $table->string('listable_type' ,200)->nullable();
            $table->string('link' ,6000)->nullable();
            $table->unsignedBigInteger('sort')->default(0);
            $table->enum('menu_type',['default','megamenu','relate'])->default('default');
            $table->boolean('header')->default(true);
            $table->boolean('footer')->default(false);
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
        Schema::dropIfExists('list');
    }
};

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
        Schema::create('slider', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('type',200);
            $table->string('banner',200)->nullable();
            $table->string('mobile_banner',200)->nullable();
            $table->string('link' ,6000)->nullable();
            $table->string('sort',200)->default(1);
            $table->boolean('follow')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider');
    }
};

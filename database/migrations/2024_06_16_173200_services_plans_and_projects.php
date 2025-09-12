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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('name',250)->unique();
            $table->string('purpose',300)->unique();
            $table->string('img',100)->nullable();
            $table->string('banner',100)->nullable();
            $table->string('mobile_banner',200)->nullable();
            $table->string('url_page' ,2000)->nullable();
            $table->string('project_page' ,2000)->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('added_by',150);
            $table->string('updated_by',150);
            $table->timestamps();
        });
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('title',600)->unique();
            $table->string('slug',2000)->unique();
            $table->string('page_title',600)->unique();
            $table->string('meta_description',600)->unique();
            $table->string('keyword',6000)->nullable();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('service')->onDelete('cascade');
            $table->string('img',100)->nullable();
            $table->string('banner',100)->nullable();
            $table->string('mobile_banner',100)->nullable();
            $table->mediumText('description')->nullable();
            $table->string('preview_page' ,2000)->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('view')->default(0);
            $table->string('added_by',150);
            $table->string('updated_by',150);
            $table->timestamps();
        });
        Schema::create('plan', function (Blueprint $table) {
            $table->id();
            $table->string('name',400);
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
            $table->mediumText('possible')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('suggest')->default(false);
            $table->boolean('infinity')->default(false);
            $table->string('price',12);
            $table->string('time',3)->nullable();
            $table->string('added_by',150);
            $table->string('updated_by',150);
            $table->timestamps();
        });
        Schema::create('possible', function (Blueprint $table) {
            $table->id();
            $table->string('name',400)->unique();
            $table->string('info_page' ,2000)->nullable();
            $table->unsignedBigInteger('sort')->default(0);
            $table->string('added_by',150);
            $table->string('updated_by',150);
            $table->timestamps();
        });
        Schema::create('project_possible', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
            $table->unsignedBigInteger('possible_id');
            $table->foreign('possible_id')->references('id')->on('possible')->onDelete('cascade');
            $table->primary(['project_id','possible_id']);

        });
        Schema::create('plan_possible', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plan')->onDelete('cascade');
            $table->unsignedBigInteger('possible_id');
            $table->foreign('possible_id')->references('id')->on('possible')->onDelete('cascade');
            $table->primary(['plan_id','possible_id']);

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

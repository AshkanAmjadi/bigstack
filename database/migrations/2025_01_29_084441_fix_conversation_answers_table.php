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

        Schema::table('answer', function (Blueprint $table) {
            $table->string('mention',500)->nullable()->after('private');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->boolean('private')->default(false)->after('slug');
            $table->string('mention',500)->nullable()->after('private');
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

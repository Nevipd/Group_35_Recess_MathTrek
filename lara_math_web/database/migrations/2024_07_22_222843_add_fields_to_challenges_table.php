<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**z
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            //
            $table->integer('num_questions')->default(10);
            $table->integer('duration')->default(60); // in minutes
            $table->integer('time_per_question')->default(60); // in seconds
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            //
            $table->dropColumn(['num_questions', 'duration', 'time_per_question']);
        });
    }
};

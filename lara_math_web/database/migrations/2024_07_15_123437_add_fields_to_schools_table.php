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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('school_registration_number')->after('address');
            $table->string('representative_email')->after('school_registration_number');
            $table->string('representative_name')->after('representative_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('school_registration_number');
            $table->dropColumn('representative_email');
            $table->dropColumn('representative_name');
        });
    }
};

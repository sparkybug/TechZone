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
        Schema::table('saved_jobs', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('user_id');
            $table->dropColumn('job_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saved_jobs', function (Blueprint $table) {
            //
        });
    }
};

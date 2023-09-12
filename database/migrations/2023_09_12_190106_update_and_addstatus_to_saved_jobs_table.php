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
            $table->dropColumn('job_tag');
            $table->dropColumn('skill_set');
            $table->dropColumn('work_period');
            $table->dropColumn('budget_des');
            $table->dropColumn('budget');
            $table->dropColumn('job_des');
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

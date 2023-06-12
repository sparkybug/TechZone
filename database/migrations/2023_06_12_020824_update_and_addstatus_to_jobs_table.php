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
        Schema::table('jobs', function (Blueprint $table) {
            $table->longText('job_tag')->change();
            $table->longText('skill_set')->change();
            $table->longText('work_period')->change();
            $table->longText('budget_des')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('job_tag')->change();
            $table->string('skill_set')->change();
            $table->string('work_period')->change();
            $table->string('budget_des')->change();
        });
    }
};

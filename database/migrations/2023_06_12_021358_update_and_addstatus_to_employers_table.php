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
        Schema::table('employers', function (Blueprint $table) {
            $table->longText('company_name')->after('email');
            $table->longText('company_rating');
            $table->longText('total_spent');
            $table->longText('company_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('company_name')->after('email');
            $table->dropColumn('company_rating');
            $table->dropColumn('total_spent');
            $table->dropColumn('company_location');
        });
    }
};

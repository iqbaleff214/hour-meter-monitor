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
        Schema::table('hour_meter_report_details', function (Blueprint $table) {
            $table->json('content')->nullable()->after('service_plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hour_meter_report_details', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }
};

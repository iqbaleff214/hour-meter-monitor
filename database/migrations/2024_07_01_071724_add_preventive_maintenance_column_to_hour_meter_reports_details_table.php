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
            $table->unsignedInteger('preventive_maintenance_hour_meter')->default(0)->after('new_hour_meter');
            $table->foreignId('category_rules_id')->nullable()->constrained()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hour_meter_reports_details', function (Blueprint $table) {
            $table->dropColumn([
                'preventive_maintenance_hour_meter',
                'category_rules_id',
            ]);
        });
    }
};

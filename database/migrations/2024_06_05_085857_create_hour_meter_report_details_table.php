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
        Schema::create('hour_meter_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hour_meter_report_id')->constrained('hour_meter_reports')->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('equipment')->cascadeOnDelete();
            $table->unsignedInteger('new_hour_meter')->default(0);
            $table->string('service_plan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hour_meter_report_details');
    }
};

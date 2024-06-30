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
        Schema::table('category_rules', function (Blueprint $table) {
            $table->unsignedInteger('min_value')->after('category_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_rules', function (Blueprint $table) {
            $table->dropColumn('min_value');
        });
    }
};

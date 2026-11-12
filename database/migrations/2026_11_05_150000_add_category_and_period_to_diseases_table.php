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
        Schema::table('diseases', function (Blueprint $table) {
            $table->string('category', 50)->default('maladie')->after('scientific_name');
            $table->string('target_crops', 255)->nullable()->after('affected_crops');
            $table->string('period', 255)->nullable()->after('target_crops');
            $table->text('control_methods')->nullable()->after('symptoms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->dropColumn(['category', 'target_crops', 'period', 'control_methods']);
        });
    }
};

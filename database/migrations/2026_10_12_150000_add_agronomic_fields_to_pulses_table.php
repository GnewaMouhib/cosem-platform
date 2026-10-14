<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pulses', function (Blueprint $table) {
            $table->string('disease_resistance')->nullable()->after('yield_potential');
            $table->string('grain_quality')->nullable()->after('disease_resistance');
            $table->string('targeted_zone')->nullable()->after('grain_quality');
        });
    }

    public function down(): void
    {
        Schema::table('pulses', function (Blueprint $table) {
            $table->dropColumn(['disease_resistance', 'grain_quality', 'targeted_zone']);
        });
    }
};

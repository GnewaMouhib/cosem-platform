<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annual_stats', function (Blueprint $table) {
            $table->decimal('feves_qx', 15, 2)->default(0)->after('pulses_qx');
            $table->decimal('pois_chiches_qx', 15, 2)->default(0)->after('feves_qx');
            $table->decimal('feveroles_qx', 15, 2)->default(0)->after('pois_chiches_qx');
            $table->decimal('lentilles_qx', 15, 2)->default(0)->after('feveroles_qx');
        });
    }

    public function down(): void
    {
        Schema::table('annual_stats', function (Blueprint $table) {
            $table->dropColumn(['feves_qx', 'pois_chiches_qx', 'feveroles_qx', 'lentilles_qx']);
        });
    }
};

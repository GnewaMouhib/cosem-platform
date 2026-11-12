<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The station enum is narrowed to the three legacy values, but the network
     * now spans a head office, a storage platform, a laboratory, a specialised
     * station and a regional depot. The enum stays authoritative at the DB level
     * rather than being loosened into a free-form string.
     */
    public function up(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->enum('type', [
                'conditioning_station',
                'storage_center',
                'central_lab',
                'specialized_station',
                'regional_depot',
                'warehouse',
                'multiplication_zone',
            ])->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->enum('type', ['conditioning_station', 'warehouse', 'multiplication_zone'])->nullable(false)->change();
        });
    }
};

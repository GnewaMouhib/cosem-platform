<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cereals', function (Blueprint $table) {
            $table->string('optimal_cycle')->nullable()->after('breeder');
            $table->string('yield_potential')->nullable()->after('optimal_cycle');
        });
    }

    public function down(): void
    {
        Schema::table('cereals', function (Blueprint $table) {
            $table->dropColumn(['optimal_cycle', 'yield_potential']);
        });
    }
};

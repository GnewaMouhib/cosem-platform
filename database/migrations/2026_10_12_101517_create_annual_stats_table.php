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
        Schema::create('annual_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained()->onDelete('cascade');
            $table->decimal('durum_wheat_qx', 15, 2)->default(0);
            $table->decimal('soft_wheat_qx', 15, 2)->default(0);
            $table->decimal('barley_qx', 15, 2)->default(0);
            $table->decimal('oats_qx', 15, 2)->default(0);
            $table->decimal('pulses_qx', 15, 2)->default(0);
            $table->decimal('total_hectares', 15, 2)->default(0);
            $table->integer('total_multipliers')->default(0);
            $table->integer('member_multipliers')->default(0);
            $table->decimal('certified_seed_pct', 5, 2)->default(0);
            $table->decimal('prebasic_seed_pct', 5, 2)->default(0);
            $table->string('financing_partner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_stats');
    }
};

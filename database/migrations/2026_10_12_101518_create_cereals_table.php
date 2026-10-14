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
        Schema::create('cereals', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['ble_dur', 'ble_tendre', 'orge', 'triticale']);
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('breeder')->nullable();
            $table->text('description')->nullable();
            $table->string('disease_resistance')->nullable();
            $table->string('targeted_zone')->nullable();
            $table->string('grain_quality')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cereals');
    }
};

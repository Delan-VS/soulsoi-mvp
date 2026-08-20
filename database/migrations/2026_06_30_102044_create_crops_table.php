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
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scientific_name')->nullable();
            $table->decimal('ideal_ph_min', 4, 2)->default(6.00);
            $table->decimal('ideal_ph_max', 4, 2)->default(7.50);
            $table->decimal('ideal_moisture_min', 5, 2)->default(40.00);
            $table->decimal('ideal_moisture_max', 5, 2)->default(80.00);
            $table->integer('growth_duration_days')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};

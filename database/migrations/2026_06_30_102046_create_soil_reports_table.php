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
        Schema::create('soil_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->date('sample_date');
            $table->string('location');
            $table->decimal('ph_level', 4, 2);
            $table->integer('nitrogen'); // in mg/kg
            $table->integer('phosphorus'); // in mg/kg
            $table->integer('potassium'); // in mg/kg
            $table->decimal('moisture', 5, 2); // percentage
            $table->string('status')->default('Pending'); // Pending, Analyzing, Completed
            $table->text('recommendation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soil_reports');
    }
};

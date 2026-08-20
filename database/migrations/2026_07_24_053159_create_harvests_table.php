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
        Schema::create('harvests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('growing'); // growing, ready, harvested
            $table->decimal('estimated_yield', 10, 2)->nullable(); // e.g. tons
            $table->decimal('actual_yield', 10, 2)->nullable();
            $table->decimal('market_value', 12, 2)->nullable(); // rupees
            $table->date('expected_harvest_date')->nullable();
            $table->date('actual_harvest_date')->nullable();
            $table->string('quality_grade')->nullable(); // Grade A, B, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};

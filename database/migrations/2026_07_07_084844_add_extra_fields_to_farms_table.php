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
        Schema::table('farms', function (Blueprint $table) {
            $table->string('secondary_crop')->nullable();
            $table->string('listing_category')->nullable();
            $table->string('location')->nullable();
            $table->integer('yielding_period')->nullable();
            $table->date('expected_start_date')->nullable();
            $table->decimal('min_investment', 12, 2)->nullable();
            $table->decimal('max_investment', 12, 2)->nullable();
            $table->decimal('expected_roi', 5, 2)->nullable();
            $table->decimal('your_contribution', 12, 2)->nullable();
            $table->string('land_certificate_path')->nullable();
            $table->string('lease_agreement_path')->nullable();
            $table->string('farm_photo_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn([
                'secondary_crop',
                'listing_category',
                'location',
                'yielding_period',
                'expected_start_date',
                'min_investment',
                'max_investment',
                'expected_roi',
                'your_contribution',
                'land_certificate_path',
                'lease_agreement_path',
                'farm_photo_path'
            ]);
        });
    }
};

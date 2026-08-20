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
            $table->json('budget_breakdown')->nullable();
            $table->json('farming_timeline')->nullable();
            $table->json('additional_photos')->nullable();
            $table->json('additional_documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn([
                'budget_breakdown',
                'farming_timeline',
                'additional_photos',
                'additional_documents'
            ]);
        });
    }
};

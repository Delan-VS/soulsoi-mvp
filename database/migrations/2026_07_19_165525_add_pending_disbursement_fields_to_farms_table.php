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
            $table->decimal('pending_disbursement_amount', 12, 2)->nullable();
            $table->string('pending_disbursement_stage')->nullable();
            $table->text('pending_disbursement_purpose')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn([
                'pending_disbursement_amount',
                'pending_disbursement_stage',
                'pending_disbursement_purpose',
            ]);
        });
    }
};

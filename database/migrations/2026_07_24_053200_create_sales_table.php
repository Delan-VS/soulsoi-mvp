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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->string('buyer_name');
            $table->decimal('sale_amount', 12, 2); // rupees
            $table->decimal('quantity_sold', 10, 2); // tons
            $table->date('sale_date');
            
            // Proofs & Compliance
            $table->string('invoice_path')->nullable();
            $table->string('blockchain_tx_hash')->nullable();
            $table->boolean('compliance_blockchain')->default(false);
            $table->boolean('compliance_audit')->default(false);
            $table->boolean('compliance_pesticide_free')->default(false);
            
            $table->string('status')->default('pending_verification'); // pending_verification, verified
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

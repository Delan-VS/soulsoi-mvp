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
        // Drop existing tables to prevent conflicts
        Schema::dropIfExists('farms');
        Schema::dropIfExists('farmers');
        Schema::dropIfExists('audit_logs');

        // Create farmers table
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('full_name');
            $table->date('dob');
            $table->string('aadhar_number');
            $table->text('address');
            $table->string('village');
            $table->string('district');
            $table->string('state');
            
            // Bank details
            $table->string('bank_name');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            
            // Verifications status
            $table->string('face_verification')->default('pending');
            $table->string('mobile_verification')->default('pending');
            $table->string('bank_verification')->default('pending');
            $table->string('document_verification')->default('pending');
            
            // Overall status
            $table->string('overall_status')->default('pending'); // pending, approved, rejected
            
            // Documents
            $table->string('aadhar_front_path')->nullable();
            $table->string('aadhar_back_path')->nullable();
            $table->string('bank_proof_path')->nullable();
            $table->string('farm_ownership_doc_path')->nullable();
            $table->string('land_certificate_path')->nullable();
            
            // Review logs
            $table->foreignId('reviewed_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
        });

        // Create farms table
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers')->onDelete('cascade');
            $table->string('name');
            $table->decimal('total_acres', 8, 2);
            $table->string('primary_crop');
            
            $table->string('status')->default('pending'); // pending, approved, rejected
            
            // Fundraising metrics & attention alerts
            $table->decimal('funding_target', 12, 2)->default(1000000.00);
            $table->decimal('funding_raised', 12, 2)->default(0.00);
            $table->integer('investor_count')->default(0);
            $table->boolean('documentation_required')->default(false);
            
            // Soil and atmosphere metrics
            $table->string('soil_ph')->nullable();
            $table->string('npk_ratio')->nullable();
            $table->string('avg_rainfall')->nullable();
            $table->string('temp_range')->nullable();
            $table->string('soil_report_path')->nullable();
            
            // Review logs
            $table->foreignId('reviewed_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
        });

        // Create audit logs table
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('action');
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
        Schema::dropIfExists('farmers');
        Schema::dropIfExists('audit_logs');
    }
};

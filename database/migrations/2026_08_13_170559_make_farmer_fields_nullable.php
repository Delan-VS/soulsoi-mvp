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
        Schema::table('farmers', function (Blueprint $table) {
            $table->date('dob')->nullable()->change();
            $table->string('aadhar_number')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
            $table->string('account_holder_name')->nullable()->change();
            $table->string('account_number')->nullable()->change();
            $table->string('ifsc_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->date('dob')->nullable(false)->change();
            $table->string('aadhar_number')->nullable(false)->change();
            $table->string('bank_name')->nullable(false)->change();
            $table->string('account_holder_name')->nullable(false)->change();
            $table->string('account_number')->nullable(false)->change();
            $table->string('ifsc_code')->nullable(false)->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            if (!Schema::hasColumn('farmers', 'aadhar_ecard_path')) {
                $table->string('aadhar_ecard_path')->nullable()->after('aadhar_back_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            if (Schema::hasColumn('farmers', 'aadhar_ecard_path')) {
                $table->dropColumn('aadhar_ecard_path');
            }
        });
    }
};


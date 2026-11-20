<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            if (!Schema::hasColumn('farmers', 'pincode')) {
                $table->string('pincode', 10)->nullable()->after('state');
            }
        });
    }

    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            if (Schema::hasColumn('farmers', 'pincode')) {
                $table->dropColumn('pincode');
            }
        });
    }
};

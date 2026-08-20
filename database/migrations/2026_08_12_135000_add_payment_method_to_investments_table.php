<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('investments') && !Schema::hasColumn('investments', 'payment_method')) {
            Schema::table('investments', function (Blueprint $table) {
                $table->string('payment_method')->nullable()->default('UPI')->after('equity_share');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('investments') && Schema::hasColumn('investments', 'payment_method')) {
            Schema::table('investments', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};

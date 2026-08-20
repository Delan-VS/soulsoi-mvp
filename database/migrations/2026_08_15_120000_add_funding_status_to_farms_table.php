<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            if (!Schema::hasColumn('farms', 'funding_status')) {
                $table->string('funding_status')->default('closed')->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            if (Schema::hasColumn('farms', 'funding_status')) {
                $table->dropColumn('funding_status');
            }
        });
    }
};

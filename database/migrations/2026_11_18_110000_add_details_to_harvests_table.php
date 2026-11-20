<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('harvests', function (Blueprint $table) {
            if (!Schema::hasColumn('harvests', 'selling_price')) {
                $table->decimal('selling_price', 12, 2)->nullable()->after('actual_yield');
            }
            if (!Schema::hasColumn('harvests', 'market_name')) {
                $table->string('market_name')->nullable()->after('quality_grade');
            }
            if (!Schema::hasColumn('harvests', 'start_date')) {
                $table->date('start_date')->nullable()->after('expected_harvest_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('harvests', function (Blueprint $table) {
            $cols = [];
            foreach (['selling_price', 'market_name', 'start_date'] as $col) {
                if (Schema::hasColumn('harvests', $col)) {
                    $cols[] = $col;
                }
            }
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};

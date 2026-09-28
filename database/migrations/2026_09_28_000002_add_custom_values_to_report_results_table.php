<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report_results', function (Blueprint $table) {
            if (!Schema::hasColumn('report_results', 'custom_values')) {
                $table->json('custom_values')->nullable()->after('specification');
            }
        });
    }

    public function down(): void
    {
        Schema::table('report_results', function (Blueprint $table) {
            if (Schema::hasColumn('report_results', 'custom_values')) {
                $table->dropColumn('custom_values');
            }
        });
    }
};

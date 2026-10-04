<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('invoices') && !Schema::hasColumn('invoices', 'deleted_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
        if (Schema::hasTable('report_types') && !Schema::hasColumn('report_types', 'deleted_at')) {
            Schema::table('report_types', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('invoices') && Schema::hasColumn('invoices', 'deleted_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
        if (Schema::hasTable('report_types') && Schema::hasColumn('report_types', 'deleted_at')) {
            Schema::table('report_types', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};

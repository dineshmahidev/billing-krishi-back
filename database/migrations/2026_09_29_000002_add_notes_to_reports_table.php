<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reports') && !Schema::hasColumn('reports', 'notes')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('remarks');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('reports') && Schema::hasColumn('reports', 'notes')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};

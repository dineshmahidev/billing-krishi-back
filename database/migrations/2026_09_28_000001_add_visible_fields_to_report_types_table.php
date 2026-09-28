<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            $table->json('visible_fields')->nullable()->after('quantity_label');
        });
    }

    public function down(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            $table->dropColumn('visible_fields');
        });
    }
};

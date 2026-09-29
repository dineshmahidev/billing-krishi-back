<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            $table->text('default_remarks')->nullable()->after('quantity_label');
            $table->text('default_notes')->nullable()->after('default_remarks');
        });
    }

    public function down(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            $table->dropColumn(['default_remarks', 'default_notes']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('report_types', function (Blueprint $table) {
            $table->string('quantity_label', 50)->default('Quantity')->after('title');
        });
    }

    public function down(): void {
        Schema::table('report_types', function (Blueprint $table) {
            $table->dropColumn('quantity_label');
        });
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('report_types', function (Blueprint $table) {
            $table->boolean('show_specification')->default(true)->after('active');
            $table->json('custom_columns')->nullable()->after('show_specification');
        });
        // convert existing data: ensure default
    }
    public function down(): void {
        Schema::table('report_types', function (Blueprint $table) {
            $table->dropColumn(['show_specification','custom_columns']);
        });
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('parameters', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('specification');
            $table->string('hsn_code')->nullable()->after('price');
        });
    }
    public function down(): void {
        Schema::table('parameters', function (Blueprint $table) {
            $table->dropColumn(['price','hsn_code']);
        });
    }
};

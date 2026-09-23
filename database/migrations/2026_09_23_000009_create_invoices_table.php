<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->cascadeOnDelete();
            $table->string('invoice_no')->unique();
            $table->string('party_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(0);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->boolean('gst_enabled')->default(true);
            $table->string('status')->default('unpaid');
            $table->timestamps();
        });
        Schema::table('lab_settings', function (Blueprint $table) {
            $table->decimal('default_gst_percent', 5, 2)->default(18)->after('signature_path');
            $table->boolean('gst_enabled')->default(true)->after('default_gst_percent');
            $table->string('gstin')->nullable()->after('gst_enabled');
            $table->string('invoice_prefix')->default('KAL-INV-')->after('gstin');
        });
    }
    public function down(): void {
        Schema::dropIfExists('invoices');
        Schema::table('lab_settings', function (Blueprint $table) {
            $table->dropColumn(['default_gst_percent','gst_enabled','gstin','invoice_prefix']);
        });
    }
};

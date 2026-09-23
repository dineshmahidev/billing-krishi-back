<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('gstin')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        // seed from existing reports party names
        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('created_by')->constrained('customers')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });
        Schema::dropIfExists('customers');
    }
};

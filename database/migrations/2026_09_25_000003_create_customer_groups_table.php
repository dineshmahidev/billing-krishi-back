<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->after('is_active')->constrained('customer_groups')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('group_id');
        });
        Schema::dropIfExists('customer_groups');
    }
};

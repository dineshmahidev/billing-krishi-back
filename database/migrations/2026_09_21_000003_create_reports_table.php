<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_no')->unique();
            $table->foreignId('report_type_id')->constrained('report_types')->cascadeOnDelete();
            $table->date('sample_date')->nullable();
            $table->date('coa_date')->nullable();
            $table->string('party_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('sample_name')->nullable();
            $table->string('nature_of_sample')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('bags_tons')->nullable();
            $table->string('buyer')->nullable();
            $table->string('seller')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['report_type_id', 'status']);
            $table->index('report_no');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

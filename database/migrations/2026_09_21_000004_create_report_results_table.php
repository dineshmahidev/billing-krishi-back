<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->foreignId('parameter_id')->constrained('parameters')->cascadeOnDelete();
            $table->string('result')->nullable();
            $table->string('specification')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->index(['report_id', 'parameter_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_results');
    }
};

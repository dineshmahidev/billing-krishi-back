<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('parameter_id')->nullable()->constrained('parameters')->nullOnDelete();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('hsn_code')->nullable();
            $table->decimal('rate', 10, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->decimal('amount', 10, 2)->default(0);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->index('invoice_id');
        });

        // Backfill existing invoices from their report's enabled parameters
        foreach (DB::table('invoices')->get() as $inv) {
            $results = DB::table('report_results')
                ->join('parameters', 'parameters.id', '=', 'report_results.parameter_id')
                ->where('report_results.report_id', $inv->report_id)
                ->where(function ($q) {
                    $q->whereNull('report_results.enabled')->orWhere('report_results.enabled', 1);
                })
                ->orderBy('report_results.display_order')
                ->get([
                    'report_results.parameter_id as parameter_id',
                    'parameters.name as name',
                    'parameters.unit as unit',
                    'parameters.hsn_code as hsn_code',
                    'parameters.price as price',
                ]);
            foreach ($results as $i => $r) {
                $rate = round(floatval($r->price), 2);
                DB::table('invoice_items')->insert([
                    'invoice_id' => $inv->id,
                    'parameter_id' => $r->parameter_id,
                    'name' => $r->name,
                    'unit' => $r->unit,
                    'hsn_code' => $r->hsn_code,
                    'rate' => $rate,
                    'qty' => 1,
                    'amount' => $rate,
                    'display_order' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void {
        Schema::dropIfExists('invoice_items');
    }
};

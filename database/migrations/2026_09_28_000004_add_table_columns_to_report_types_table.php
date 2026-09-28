<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            if (!Schema::hasColumn('report_types', 'table_columns')) {
                $table->json('table_columns')->nullable()->after('custom_columns');
            }
        });

        // Initialize default table_columns for existing report types and update default title to TEST REPORT
        $types = DB::table('report_types')->get();
        foreach ($types as $type) {
            $customCols = json_decode($type->custom_columns ?? '[]', true) ?: [];
            $showSpec = (bool)($type->show_specification ?? true);

            $columns = [
                ['key' => 's_no', 'label' => 'S.NO', 'visible' => true, 'type' => 'system'],
                ['key' => 'parameter', 'label' => 'PARAMETER', 'visible' => true, 'type' => 'system'],
            ];

            if ($showSpec) {
                $columns[] = ['key' => 'specification', 'label' => 'SPECIFICATION', 'visible' => true, 'type' => 'system'];
            }

            foreach ($customCols as $idx => $col) {
                $columns[] = [
                    'key' => 'custom_' . ($idx + 1),
                    'label' => strtoupper($col),
                    'visible' => true,
                    'type' => 'custom'
                ];
            }

            $columns[] = ['key' => 'result', 'label' => 'RESULT', 'visible' => true, 'type' => 'system'];

            $updateData = ['table_columns' => json_encode($columns)];
            if ($type->title === 'CERTIFICATE OF ANALYSIS') {
                $updateData['title'] = 'TEST REPORT';
            }

            DB::table('report_types')->where('id', $type->id)->update($updateData);
        }
    }

    public function down(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            if (Schema::hasColumn('report_types', 'table_columns')) {
                $table->dropColumn('table_columns');
            }
        });
    }
};

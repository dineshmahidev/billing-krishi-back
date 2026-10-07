<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('depositor_name')->nullable()->after('seller');
            $table->string('cid_no')->nullable()->after('depositor_name');
            $table->string('si_no')->nullable()->after('cid_no');
            $table->string('lot_no')->nullable()->after('si_no');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['depositor_name', 'cid_no', 'si_no', 'lot_no']);
        });
    }
};

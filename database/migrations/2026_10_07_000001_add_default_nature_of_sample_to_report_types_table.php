<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            $table->string('default_nature_of_sample')->nullable()->after('quantity_label');
        });
    }

    public function down(): void
    {
        Schema::table('report_types', function (Blueprint $table) {
            $table->dropColumn('default_nature_of_sample');
        });
    }
};

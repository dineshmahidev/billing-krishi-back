<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lab_settings', function (Blueprint $table) {
            $table->string('website')->nullable()->default('https://krishianalyticallab.com')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('lab_settings', function (Blueprint $table) {
            $table->dropColumn('website');
        });
    }
};

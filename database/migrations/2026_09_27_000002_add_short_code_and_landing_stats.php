<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('parameters') && !Schema::hasColumn('parameters', 'short_code')) {
            Schema::table('parameters', function (Blueprint $table) {
                $table->string('short_code', 50)->nullable()->after('name');
            });
        }

        if (Schema::hasTable('landing_contents')) {
            Schema::table('landing_contents', function (Blueprint $table) {
                if (!Schema::hasColumn('landing_contents', 'stat1_value')) {
                    $table->string('stat1_value', 50)->default('5');
                    $table->string('stat1_label', 100)->default('Report Types');
                }
                if (!Schema::hasColumn('landing_contents', 'stat2_value')) {
                    $table->string('stat2_value', 50)->default('38+');
                    $table->string('stat2_label', 100)->default('Test Parameters');
                }
                if (!Schema::hasColumn('landing_contents', 'stat3_value')) {
                    $table->string('stat3_value', 50)->default('1000+');
                    $table->string('stat3_label', 100)->default('Reports Generated');
                }
                if (!Schema::hasColumn('landing_contents', 'stat4_value')) {
                    $table->string('stat4_value', 50)->default('24/7');
                    $table->string('stat4_label', 100)->default('Support');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('parameters') && Schema::hasColumn('parameters', 'short_code')) {
            Schema::table('parameters', function (Blueprint $table) {
                $table->dropColumn('short_code');
            });
        }

        if (Schema::hasTable('landing_contents')) {
            Schema::table('landing_contents', function (Blueprint $table) {
                $table->dropColumn([
                    'stat1_value', 'stat1_label',
                    'stat2_value', 'stat2_label',
                    'stat3_value', 'stat3_label',
                    'stat4_value', 'stat4_label',
                ]);
            });
        }
    }
};

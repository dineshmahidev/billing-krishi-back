<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('landing_contents') && !Schema::hasColumn('landing_contents', 'map_embed_url')) {
            Schema::table('landing_contents', function (Blueprint $table) {
                $table->text('map_embed_url')->nullable()->after('contact_hours');
            });
        }
    }

    public function down(): void {
        if (Schema::hasTable('landing_contents') && Schema::hasColumn('landing_contents', 'map_embed_url')) {
            Schema::table('landing_contents', function (Blueprint $table) {
                $table->dropColumn('map_embed_url');
            });
        }
    }
};

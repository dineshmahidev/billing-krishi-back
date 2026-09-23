<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('landing_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_badge')->default('NABL-Standard Laboratory • Kangeyam');
            $table->string('hero_title')->default('Accurate Lab Reports. Delivered Fast.');
            $table->string('hero_highlight')->default('Reports.');
            $table->text('hero_desc')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('about_title')->default('About Krishi Analytical Lab');
            $table->text('about_desc')->nullable();
            $table->string('about_image')->nullable();
            $table->string('contact_phone')->default('+91 63793 12357');
            $table->string('contact_email')->default('krishianalyticallab@gmail.com');
            $table->text('contact_address')->nullable();
            $table->string('contact_hours')->default('Mon - Sat: 9am - 6pm');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('landing_contents');
    }
};

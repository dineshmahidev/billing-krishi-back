<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('type')->nullable();
            $table->string('loc')->nullable();
            $table->text('text');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        if (DB::table('testimonials')->count() === 0) {
            $now = now();
            DB::table('testimonials')->insert([
                ['company' => 'SM Traders', 'type' => 'Oil Seeds & Grain Merchant', 'loc' => 'Kangeyam', 'text' => 'Krishi Lab provides fast 24-hour Certificate of Analysis for our oil seed shipments. Extremely reliable testing quality in Kangeyam!', 'rating' => 5, 'is_active' => 1, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['company' => 'Shree Feeds', 'type' => 'Animal Feed Manufacturer', 'loc' => 'Tiruppur', 'text' => 'Accurate moisture, protein, and fat testing for our animal feed batches. Their clear COA reports help us maintain feed standard quality.', 'rating' => 5, 'is_active' => 1, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
                ['company' => 'AMARJOTHI RICE MILL', 'type' => 'Rice Mill & Agro Foods', 'loc' => 'Kangeyam', 'text' => 'Krishi Analytical Lab provides rapid and accurate quality testing for our rice mill products. Highly reliable testing quality and report speed!', 'rating' => 5, 'is_active' => 1, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
                ['company' => 'THIRUMAGAL TRADERS', 'type' => 'Grain & Feed Merchant', 'loc' => 'Tiruppur', 'text' => 'Fast turn-around time and trustworthy Certificate of Analysis reports. Outstanding service quality and professional staff support.', 'rating' => 5, 'is_active' => 1, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }

    public function down(): void {
        Schema::dropIfExists('testimonials');
    }
};

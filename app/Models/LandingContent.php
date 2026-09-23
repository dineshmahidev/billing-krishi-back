<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LandingContent extends Model
{
    protected $fillable = [
        'hero_badge','hero_title','hero_highlight','hero_desc','hero_image',
        'about_title','about_desc','about_image',
        'contact_phone','contact_email','contact_address','contact_hours'
    ];

    public static function current(): self
    {
        return self::first() ?? self::create([
            'hero_badge' => 'NABL-Standard Laboratory • Kangeyam',
            'hero_title' => 'Accurate Lab Reports. Delivered Fast.',
            'hero_desc' => 'Professional Certificate of Analysis for Water, Oil, Ghee, Animal Feed & Rice Bran. Trusted by industries across Tamil Nadu for precise, reliable testing.',
            'about_title' => 'About Krishi Analytical Lab',
            'about_desc' => 'We are a dedicated analytical laboratory based in Kangeyam, Tiruppur District. We specialize in Certificate of Analysis (COA) for agro and food products. Our mission is to provide quick, accurate, and affordable testing with a clean, professional report system built for non-technical staff.',
            'contact_phone' => '+91 63793 12357',
            'contact_email' => 'krishianalyticallab@gmail.com',
            'contact_address' => '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701',
            'contact_hours' => 'Mon - Sat: 9am - 6pm',
        ]);
    }
}

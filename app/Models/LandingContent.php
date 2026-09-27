<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LandingContent extends Model
{
    protected $fillable = [
        'hero_badge','hero_title','hero_highlight','hero_desc','hero_image',
        'stat1_value','stat1_label','stat2_value','stat2_label','stat3_value','stat3_label','stat4_value','stat4_label',
        'about_title','about_desc','about_image',
        'contact_phone','contact_email','contact_address','contact_hours','map_embed_url'
    ];

    public static function current(): self
    {
        return self::first() ?? self::create([
            'hero_badge' => 'NABL-Standard Laboratory • Kangeyam',
            'hero_title' => 'Accurate Lab Reports. Delivered Fast.',
            'hero_desc' => 'Professional Certificate of Analysis for Water, Oil, Ghee, Animal Feed & Rice Bran. Trusted by industries across Tamil Nadu for precise, reliable testing.',
            'stat1_value' => '5',
            'stat1_label' => 'Report Types',
            'stat2_value' => '38+',
            'stat2_label' => 'Test Parameters',
            'stat3_value' => '1000+',
            'stat3_label' => 'Reports Generated',
            'stat4_value' => '24/7',
            'stat4_label' => 'Support',
            'about_title' => 'About Krishi Analytical Lab',
            'about_desc' => 'We are a dedicated analytical laboratory based in Kangeyam, Tiruppur District. We specialize in Certificate of Analysis (COA) for agro and food products. Our mission is to provide quick, accurate, and affordable testing with a clean, professional report system built for non-technical staff.',
            'contact_phone' => '+91 63793 12357',
            'contact_email' => 'krishianalyticallab@gmail.com',
            'contact_address' => '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701',
            'contact_hours' => 'Mon - Sat: 9am - 6pm',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.3589961733287!2d77.5525126!3d11.0116687!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba9a180a88cb8a7%3A0xba96d3fb508d6259!2sKrishi%20Analytical%20Lab!5e0!3m2!1sen!2sin!4v1790512063225!5m2!1sen!2sin',
        ]);
    }
}

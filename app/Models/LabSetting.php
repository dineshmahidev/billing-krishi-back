<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabSetting extends Model
{
    protected $fillable = ['lab_name','tagline','address','phone','email','logo_path','seal_path','signature_path','default_gst_percent','gst_enabled','gstin','invoice_prefix'];

    public static function current(): self
    {
        return self::first() ?? self::create([
            'lab_name'=>'KRISHI ANALYTICAL LAB',
            'tagline'=>'Discovering Solutions, One Test at a Time',
            'address'=>'182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701, Tiruppur Dist, Tamil Nadu',
            'phone'=>'+91 63793 12357',
            'email'=>'info@krishianalyticallab.com',
        ]);
    }
}

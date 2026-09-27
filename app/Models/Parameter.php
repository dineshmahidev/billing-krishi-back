<?php

namespace App\Models;

use App\Models\Concerns\DemoScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use DemoScoped, SoftDeletes;

    protected $fillable = ['report_type_id','name','short_code','unit','specification','price','hsn_code','display_order','active','is_demo'];
    protected $casts = ['active'=>'boolean', 'price'=>'decimal:2', 'is_demo'=>'boolean'];

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(ReportType::class);
    }

    /**
     * Return short acronym/initials for concise settlement statement display.
     * If short_code is set in admin, use it. Otherwise compute from name/parentheses.
     */
    public function getShortCode(): string
    {
        if (!empty($this->short_code)) {
            return trim($this->short_code);
        }

        $name = trim($this->name);

        // Check if there is something in parentheses, e.g. "SAND & SILICA (SS)" -> "SS", "TOTAL HARDNESS (TH)" -> "TH"
        if (preg_match('/\(([A-Za-z0-9\s\+\-\%\@]{1,12})\)/', $name, $matches)) {
            $candidate = trim($matches[1]);
            if (strlen($candidate) <= 8) {
                return strtoupper($candidate);
            }
        }

        // Special common lab mappings
        $upper = strtoupper($name);
        if (strcasecmp($name, 'pH') === 0 || $upper === 'PH' || str_contains($upper, 'PH VALUE')) return 'pH';
        if (str_contains($upper, 'B.R') || str_contains($upper, 'BR READING')) {
            if (preg_match('/@\s*(\d+\s*C)/i', $upper, $m)) {
                return 'BR @' . str_replace(' ', '', $m[1]);
            }
            return 'BR';
        }
        if (str_contains($upper, 'FREE FATTY ACID') || str_contains($upper, 'F.F.A')) return 'FFA';
        if (str_contains($upper, 'OIL CONTENT')) return 'OC';
        if (str_contains($upper, 'MOISTURE')) return 'MOISTURE';
        if (str_contains($upper, 'SAPONIFICATION')) return 'SV';
        if (str_contains($upper, 'ACID VALUE')) return 'AV';
        if (str_contains($upper, 'IODINE VALUE')) return 'IV';
        if (str_contains($upper, 'PEROXIDE VALUE')) return 'PV';
        if (str_contains($upper, 'POLENSKE')) return 'POLENSKE';
        if (str_contains($upper, 'REICHERT')) return 'RM';
        if (str_contains($upper, 'TOTAL DISSOLVED')) return 'TDS';
        if (str_contains($upper, 'TOTAL HARDNESS')) return 'TH';
        if (str_contains($upper, 'TOTAL SUSPENDED')) return 'TSS';
        if (str_contains($upper, 'ELECTRICAL CONDUCTIVITY')) return 'EC';
        if (str_contains($upper, 'TURBIDITY')) return 'TURBIDITY';
        if (str_contains($upper, 'ALKALINITY')) return 'ALKALINITY';
        if (str_contains($upper, 'CHLORIDE')) return 'CHLORIDE';
        if (str_contains($upper, 'SULPHATE')) return 'SULPHATE';
        if (str_contains($upper, 'AFLATOXIN')) return 'AFLATOXIN B1';
        if (str_contains($upper, 'UREA')) return 'UREA';
        if (str_contains($upper, 'SAND & SILICA') || str_contains($upper, 'SAND AND SILICA')) return 'SS';

        // Otherwise generate acronym from significant words
        $words = preg_split('/[\s\-\_\/\&]+/', $name);
        $acronym = '';
        foreach ($words as $w) {
            $w = trim($w);
            if ($w !== '' && !in_array(strtolower($w), ['and', 'of', 'for', 'in', 'the', 'at', 'to', 'is', 'a', 'an'])) {
                $acronym .= strtoupper($w[0]);
            }
        }
        return $acronym ?: strtoupper(substr($name, 0, 4));
    }
}

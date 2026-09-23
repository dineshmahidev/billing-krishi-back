<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parameter extends Model
{
    protected $fillable = ['report_type_id','name','unit','specification','price','hsn_code','display_order','active'];
    protected $casts = ['active'=>'boolean', 'price'=>'decimal:2'];

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(ReportType::class);
    }
}

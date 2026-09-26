<?php

namespace App\Models;

use App\Models\Concerns\DemoScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use DemoScoped, SoftDeletes;

    protected $fillable = ['report_type_id','name','unit','specification','price','hsn_code','display_order','active','is_demo'];
    protected $casts = ['active'=>'boolean', 'price'=>'decimal:2', 'is_demo'=>'boolean'];

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(ReportType::class);
    }
}

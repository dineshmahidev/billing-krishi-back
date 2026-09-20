<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'report_no','report_type_id','sample_date','coa_date','party_name','customer_name',
        'sample_name','nature_of_sample','vehicle_no','bill_no','bags_tons','buyer','seller',
        'remarks','status','created_by'
    ];

    protected $casts = [
        'sample_date'=>'date',
        'coa_date'=>'date',
    ];

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(ReportType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function results(): HasMany
    {
        return $this->hasMany(ReportResult::class)->orderBy('display_order');
    }
}

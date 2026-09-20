<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportResult extends Model
{
    protected $fillable = ['report_id','parameter_id','result','specification','display_order'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parameter extends Model
{
    protected $fillable = ['report_type_id','name','unit','specification','display_order','active'];
    protected $casts = ['active'=>'boolean'];

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(ReportType::class);
    }
}

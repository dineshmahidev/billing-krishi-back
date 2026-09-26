<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id','parameter_id','name','unit','hsn_code','rate','qty','amount','display_order'];
    protected $casts = ['rate'=>'decimal:2','qty'=>'integer','amount'=>'decimal:2'];

    public function invoice(): BelongsTo { return $this->belongsTo(Invoice::class); }
    public function parameter(): BelongsTo { return $this->belongsTo(Parameter::class)->withTrashed(); }
}

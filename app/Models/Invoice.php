<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = ['report_id','invoice_no','party_name','customer_name','subtotal','gst_percent','gst_amount','total_amount','gst_enabled','status'];
    protected $casts = ['subtotal'=>'decimal:2','gst_percent'=>'decimal:2','gst_amount'=>'decimal:2','total_amount'=>'decimal:2','gst_enabled'=>'boolean'];

    public function report(): BelongsTo { return $this->belongsTo(Report::class); }

    public static function nextNo(): string
    {
        $lab = LabSetting::current();
        $prefix = $lab->invoice_prefix ?? 'KAL-INV-';
        $last = self::where('invoice_no','like',$prefix.'%')->orderByRaw("CAST(SUBSTRING(invoice_no, ".(strlen($prefix)+1).") AS UNSIGNED) DESC")->first();
        $next = $last ? intval(substr($last->invoice_no, strlen($prefix))) + 1 : 1;
        $candidate = $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
        while (self::where('invoice_no',$candidate)->exists()) { $next++; $candidate = $prefix . str_pad($next,4,'0',STR_PAD_LEFT); }
        return $candidate;
    }
}

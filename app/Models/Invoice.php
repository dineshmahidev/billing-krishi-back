<?php
namespace App\Models;
use App\Models\Concerns\DemoScoped;
use App\Models\Scopes\DemoScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use DemoScoped;

    protected $fillable = ['report_id','invoice_no','party_name','customer_name','subtotal','gst_percent','gst_amount','total_amount','gst_enabled','status','is_demo'];
    protected $casts = ['subtotal'=>'decimal:2','gst_percent'=>'decimal:2','gst_amount'=>'decimal:2','total_amount'=>'decimal:2','gst_enabled'=>'boolean','is_demo'=>'boolean'];

    public function report(): BelongsTo { return $this->belongsTo(Report::class); }

    public function items(): HasMany { return $this->hasMany(InvoiceItem::class); }

    /**
     * Rebuild line items from the report's enabled parameters.
     * Parameter rows stay static (add/remove follows the report) but
     * previously edited rates / quantities are preserved per parameter.
     */
    public function syncItems(?Report $report = null): void
    {
        $report = $report ?? $this->report()->with('results.parameter')->first();
        if (!$report) return;
        $results = $report->results->filter(fn($r) => $r->enabled !== false)->values();
        $existing = $this->items()->get()->keyBy('parameter_id');
        $this->items()->delete();
        $order = 0;
        foreach ($results as $res) {
            $order++;
            $item = $existing->get($res->parameter_id);
            $rate = $item ? floatval($item->rate) : floatval($res->parameter->price ?? 0);
            $qty = $item ? max(1, (int)$item->qty) : 1;
            InvoiceItem::create([
                'invoice_id' => $this->id,
                'parameter_id' => $res->parameter_id,
                'name' => $res->parameter->name ?? 'Test',
                'unit' => $res->parameter->unit ?? null,
                'hsn_code' => $res->parameter->hsn_code ?? null,
                'rate' => round($rate, 2),
                'qty' => $qty,
                'amount' => round($rate * $qty, 2),
                'display_order' => $order,
            ]);
        }
    }

    public function recalcTotals(): void
    {
        $subtotal = round(floatval($this->items()->sum('amount')), 2);
        $gstAmount = $this->gst_enabled ? round($subtotal * floatval($this->gst_percent) / 100, 2) : 0;
        $this->update(['subtotal'=>$subtotal, 'gst_amount'=>$gstAmount, 'total_amount'=>round($subtotal + $gstAmount, 2)]);
    }

    public static function nextNo(): string
    {
        $lab = LabSetting::current();
        $prefix = $lab->invoice_prefix ?? 'KAL-INV-';
        $base = self::withoutGlobalScope(DemoScope::class);
        $last = (clone $base)->where('invoice_no','like',$prefix.'%')->orderByRaw("CAST(SUBSTRING(invoice_no, ".(strlen($prefix)+1).") AS UNSIGNED) DESC")->first();
        $next = $last ? intval(substr($last->invoice_no, strlen($prefix))) + 1 : 1;
        $candidate = $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
        while ((clone $base)->where('invoice_no',$candidate)->exists()) { $next++; $candidate = $prefix . str_pad($next,4,'0',STR_PAD_LEFT); }
        return $candidate;
    }
}

<!DOCTYPE html><html><head><meta charset="utf-8"><style>
@page{size:A4 portrait; margin:136px 26px 74px 26px;}
*{font-family:Krishi,Helvetica,Arial,sans-serif; box-sizing:border-box;}
body{font-size:10.5px; color:#1F2937; margin:0; background:transparent;}

.bg-letterhead {
  position: fixed;
  top: -136px;
  left: -26px;
  width: 210mm;
  height: 297mm;
  z-index: -1000;
}

.title{background:#EAF7F0; color:#0B6B43; display:inline-block; padding:4px 14px; font-weight:bold; font-size:12px; letter-spacing:1.5px; margin:2px 0 4px 0;}
.meta{width:100%; border-collapse:collapse; font-size:10px; border:1.5px solid #1F2937; margin-top:2px;}
.meta td{border:1px solid #1F2937; padding:4.5px 6px; height:20px;}
.meta-label{background:#EAF7F0; font-weight:700; width:130px; border:1px solid #1F2937;}
.items{width:100%; border-collapse:collapse; border:1.5px solid #1F2937; margin-top:6px;}
.items th{background:#EAF7F0; color:#0B6B43; padding:5px 6px; font-size:9.5px; font-weight:bold; border:1px solid #1F2937; text-transform:uppercase; letter-spacing:0.5px;}
.items td{border:1px solid #1F2937; padding:4.5px 6px; height:20px; font-size:10px;}
.items tr:nth-child(even) td{background:#F9FAFB;}
.totals{width:260px; border-collapse:collapse; margin-left:auto; margin-top:6px; border:1.5px solid #1F2937;}
.totals td{border:1px solid #1F2937; padding:4px 6px; font-size:10.5px;}
.totals .label{background:#EAF7F0; font-weight:700;}
.grand{background:#EAF7F0; color:#0B6B43; font-weight:bold;}
.sig-container{width:100%; margin-top:14px; page-break-inside:avoid; clear:both;}
.signature-area{float:right; width:180px; text-align:center; page-break-inside:avoid;}
.sig-line{border-top:1.5px solid #1F2937; margin-top:4px; padding-top:4px; font-weight:bold; font-size:10px;}
.sig-sub{font-size:8.5px; color:#6B7280; margin-top:1px;}
.sig-img{height:44px; width:auto; max-width:150px; object-fit:contain; display:block; margin:0 auto 2px auto;}
</style></head><body>
@php
  $letterheadPath = public_path('letterhead.png');
  $hasLetterhead = file_exists($letterheadPath);
  $gstin=$lab->gstin??'33AAAFK8921B1Z2';
  $fmt = function($v){ $v = round(floatval($v), 2); return (fmod($v, 1) == 0) ? number_format($v, 0) : number_format($v, 2); };
@endphp

@if($hasLetterhead)
  <div class="bg-letterhead">
    <img src="{{ $letterheadPath }}" style="width: 210mm; height: 297mm; display: block;" alt="letterhead">
  </div>
@endif

<div style="text-align:center;"><div class="title">TAX INVOICE</div></div>
<table style="width:100%; border:none; border-collapse:collapse; font-size:9.5px; margin: 2px 0;">
<tr>
<td style="border:none; padding:0; text-align:left;">Date: <strong>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</strong></td>
<td style="border:none; padding:0; text-align:right;">Invoice No: <strong style="border:1px solid #1F2937; padding:1.5px 5px; font-family:monospace; font-size:10.5px;">{{$invoice->invoice_no}}</strong></td>
</tr>
</table>

@php
  $custGroup = $report->customer?->group?->name ?? null;
@endphp
<table class="meta">
<tr>
  <td class="meta-label">Party Name</td>
  <td>
    <strong>{{ $invoice->party_name ?? $invoice->customer_name ?? $report->party_name ?? $report->customer_name ?? '' }}</strong>
    @if($custGroup)<span style="color:#0B6B43; font-size:9px; font-weight:bold; margin-left:4px;">(Group: {{ $custGroup }})</span>@endif
  </td>
  <td class="meta-label">Sample Name</td>
  <td>{!! $report->sample_name ? e($report->sample_name) : '&nbsp;' !!}</td>
</tr>
<tr><td class="meta-label">Report No</td><td colspan="3">{{ $report->report_no }}</td></tr>
</table>

<table class="items">
<thead>
<tr><th style="width:34px;">S.No</th><th>Test Parameter</th><th style="width:46px;">Qty</th><th style="width:70px;">HSN</th><th style="width:80px;">Rate (₹)</th><th style="width:90px;">Amount (₹)</th></tr>
</thead>
<tbody>
@php $invItems = $invoice->items->sortBy('display_order')->values(); @endphp
@if($invItems->count())
@foreach($invItems as $i => $it)
@php $z = ($i % 2 === 1) ? 'background:#F9FAFB;' : ''; @endphp
<tr><td style="text-align:center; {{ $z }}">{{$i+1}}</td><td style="{{ $z }}"><strong>{{$it->name}}</strong> @if($it->unit && $it->unit !== '%') <span style="color:#6B7280;">({{$it->unit}})</span> @endif</td><td style="text-align:center; {{ $z }}">{{intval($it->qty)}}</td><td style="text-align:center; {{ $z }}">{{$it->hsn_code ?? '-'}}</td><td style="text-align:right; {{ $z }}">{{ $fmt($it->rate) }}</td><td style="text-align:right; {{ $z }}">{{ $fmt($it->amount) }}</td></tr>
@endforeach
@else
@foreach($report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)->values() as $i => $res)
@php $z = ($i % 2 === 1) ? 'background:#F9FAFB;' : ''; @endphp
<tr><td style="text-align:center; {{ $z }}">{{$i+1}}</td><td style="{{ $z }}"><strong>{{$res->parameter->name}}</strong> @if($res->parameter->unit && $res->parameter->unit !== '%') <span style="color:#6B7280;">({{$res->parameter->unit}})</span> @endif</td><td style="text-align:center; {{ $z }}">1</td><td style="text-align:center; {{ $z }}">{{$res->parameter->hsn_code ?? '-'}}</td><td style="text-align:right; {{ $z }}">{{ $fmt($res->parameter->price ?? 0) }}</td><td style="text-align:right; {{ $z }}">{{ $fmt($res->parameter->price ?? 0) }}</td></tr>
@endforeach
@endif
</tbody>
</table>

<table class="totals">
<tr><td class="label">Subtotal</td><td style="text-align:right;">₹ {{ $fmt($invoice->subtotal) }}</td></tr>
@if($invoice->gst_enabled)
<tr><td class="label">GST ({{ rtrim(rtrim(number_format($invoice->gst_percent,2), '0'), '.') }}%)</td><td style="text-align:right;">₹ {{ $fmt($invoice->gst_amount) }}</td></tr>
@endif
<tr class="grand"><td>Total Amount</td><td style="text-align:right;">₹ {{ $fmt($invoice->total_amount) }}</td></tr>
</table>

@if($invoice->gst_enabled && $gstin)
<div style="font-size:7.5px; color:#6B7280; margin-top:4px; text-align:right;">GSTIN: {{$gstin}} • HSN as per test • Round off as applicable</div>
@endif

<div class="sig-container">
  <div class="signature-area">
    @php $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null; @endphp
    @if($sigPath)<img src="{{ $sigPath }}" class="sig-img" alt="signature">@else<div style="height:44px;">&nbsp;</div>@endif
    <div class="sig-line">Authorized Signatory</div>
    <div class="sig-sub">KRISHI ANALYTICAL LAB</div>
  </div>
</div>

<script type="text/php">
  if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
      if ($pageCount > 1) {
        $text = "Page " . $pageNumber . " of " . $pageCount;
        $size = 7.5;
        $font = $fontMetrics->getFont("Helvetica");
        $width = $fontMetrics->getTextWidth($text, $font, $size);
        $x = ($canvas->get_width() - $width) / 2;
        $y = $canvas->get_height() - 14;
        $canvas->text($x, $y, $text, $font, $size, array(0.42, 0.45, 0.5));
      }
    });
  }
</script>
</body></html>

<!DOCTYPE html><html><head><meta charset="utf-8"><style>
@page{size:A4 portrait; margin:168px 14px 78px 14px;}
*{font-family:Krishi,Helvetica,Arial,sans-serif; box-sizing:border-box;}
body{font-size:11px; color:#1F2937; margin:0;}
.header{position:fixed; top:-168px; left:0; right:0; height:144px; border-bottom:3px solid #0B6B43; padding:8px 14px; text-align:center;}
.header-group{width:100%; border-collapse:collapse;}
.header-group td{vertical-align:middle; padding:0; border:none;}
.logo{height:128px; width:128px; object-fit:contain; display:inline-block;}
.brand-block{display:block; width:100%; text-align:center;}
.brand-name{font-weight:bold; color:#0B6B43; font-size:36px; letter-spacing:0.5px; line-height:1.1; margin:0; text-align:center;}
.brand-tagline{font-size:14px; color:#374151; font-weight:bold; letter-spacing:0.5px; margin-top:6px; text-align:center;}
.footer{position:fixed; bottom:-66px; left:0; right:0; height:64px; border-top:2.5px solid #168B57; text-align:center; font-size:9px; color:#6B7280; padding-top:0; background:#fff;}
.footer-address{font-size:11px; font-weight:700; color:#1F2937; margin-top:5px; text-align:center;}
.footer-contact{margin:5px 14px 0; background:#EAF7F0; border-top:1.5px solid #A7D7C1; border-bottom:1.5px solid #A7D7C1; padding:4px 8px; font-size:9.5px; color:#1F2937; font-weight:700;}
.footer-sep{color:#9CA3AF; margin:0 10px;}
.title{background:#EAF7F0; color:#0B6B43; display:inline-block; padding:5px 16px; font-weight:bold; font-size:13px; letter-spacing:1px; margin:8px 0;}
.box{border:1.5px solid #1F2937; padding:10px; margin:8px 0;}
.meta{width:100%; border-collapse:collapse; font-size:10.5px; border:1.5px solid #1F2937;}
.meta td{border:1px solid #1F2937; padding:6px 8px; height:22px;}
.meta-label{background:#EAF7F0; font-weight:700; width:140px; border:1px solid #1F2937;}
.items{width:100%; border-collapse:collapse; border:1.5px solid #1F2937; margin-top:10px;}
.items th{background:#EAF7F0; color:#0B6B43; padding:7px 8px; font-size:10px; font-weight:bold; border:1px solid #1F2937; text-transform:uppercase; letter-spacing:0.5px;}
.items td{border:1px solid #1F2937; padding:7px 8px; height:22px; font-size:11px;}
.items tr:nth-child(even) td{background:#F9FAFB;}
.totals{width:280px; border-collapse:collapse; margin-left:auto; margin-top:10px; border:1.5px solid #1F2937;}
.totals td{border:1px solid #1F2937; padding:6px 8px; font-size:11px;}
.totals .label{background:#EAF7F0; font-weight:700;}
.grand{background:#EAF7F0; color:#0B6B43; font-weight:bold;}
.signature-area{position:absolute; bottom:18px; right:14px; width:200px; text-align:center; page-break-inside:avoid;}
.sig-line{border-top:1.5px solid #1F2937; margin-top:6px; padding-top:5px; font-weight:bold; font-size:11px;}
.sig-sub{font-size:9px; color:#6B7280; margin-top:2px;}
.sig-img{height:64px; width:auto; max-width:170px; object-fit:contain; display:block; margin:0 auto 4px auto;}
</style></head><body>
@php
  $labName=$lab->lab_name??'KRISHI ANALYTICAL LAB';
  $tagline=$lab->tagline??'Discovering Solutions, One Test at a Time';
  $addr=$lab->address??'182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701, Tiruppur Dist, Tamil Nadu';
  $phone=$lab->phone??'+91 63793 12357';
  $email=$lab->email??'info@krishianalyticallab.com';
  $gstin=$lab->gstin??'33AAAFK8921B1Z2';
  $logoPath=file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
  $fmt = function($v){ $v = round(floatval($v), 2); return (fmod($v, 1) == 0) ? number_format($v, 0) : number_format($v, 2); };
@endphp
<div class="header">
  <table class="header-group">
    <tr>
      <td style="width:150px; text-align:left;">@if(file_exists($logoPath))<img src="{{$logoPath}}" class="logo" alt="logo">@endif</td>
      <td class="brand-block">
        <div class="brand-name">{{$labName}}</div>
        <div class="brand-tagline">"{{ $tagline }}"</div>
      </td>
    </tr>
  </table>
</div>
<div class="footer">
  <div class="footer-address">{{$addr}}@if($gstin && $invoice->gst_enabled) &nbsp;•&nbsp; GSTIN: {{$gstin}} @endif</div>
  <div class="footer-contact">
    <span>{{$email}}</span><span class="footer-sep">|</span><span>{{$phone}}</span><span class="footer-sep">|</span><span>+91 94433 12345</span>
  </div>
</div>

<div style="text-align:center;"><div class="title">TAX INVOICE</div></div>
<table style="width:100%; border:none; border-collapse:collapse; font-size:9px; margin-top:4px;">
<tr>
<td style="border:none; padding:0; text-align:left;">Date: <strong>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</strong></td>
<td style="border:none; padding:0; text-align:right;">Invoice No: <strong style="border:1px solid #1F2937; padding:2px 6px; font-family:monospace; font-size:11px;">{{$invoice->invoice_no}}</strong></td>
</tr>
</table>

<table class="meta">
<tr><td class="meta-label">Party Name</td><td><strong>{{ $invoice->party_name ?? $invoice->customer_name ?? $report->party_name ?? $report->customer_name ?? '' }}</strong></td><td class="meta-label">Sample Name</td><td>{!! $report->sample_name ? e($report->sample_name) : '&nbsp;' !!}</td></tr>
<tr><td class="meta-label">Report No</td><td colspan="3">{{ $report->report_no }}</td></tr>
</table>

<div style="text-align:center;"><div class="title">Test Detail</div></div>
<table class="items">
<thead>
<tr><th style="width:40px;">S.No</th><th>Test Parameter</th><th style="width:52px;">Qty</th><th style="width:80px;">HSN</th><th style="width:90px;">Rate (₹)</th><th style="width:100px;">Amount (₹)</th></tr>
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
<div style="font-size:8px; color:#6B7280; margin-top:6px; text-align:right;">GSTIN: {{$gstin}} • HSN as per test • Round off as applicable</div>
@endif

<div class="signature-area">
@php $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null; @endphp
@if($sigPath)<img src="{{ $sigPath }}" class="sig-img" alt="signature">@else<div style="height:52px;">&nbsp;</div>@endif
<div class="sig-line">Authorized Signatory</div>
<div class="sig-sub">KRISHI ANALYTICAL LAB</div>
</div>
</body></html>

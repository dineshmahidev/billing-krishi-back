<!DOCTYPE html><html><head><meta charset="utf-8"><style>
@page{size:A4 portrait; margin:138px 14px 78px 14px;}
*{font-family:Helvetica,Arial,sans-serif; box-sizing:border-box;}
body{font-size:11px; color:#1F2937; margin:0;}
.header{position:fixed; top:-128px; left:0; right:0; height:120px; border-bottom:2.5px solid #0B6B43; background:#fff; padding-bottom:6px; text-align:center;}
.logo{height:96px; width:96px; object-fit:contain; display:inline-block;}
.brand-block{display:inline-block; vertical-align:middle; text-align:center; margin-left:10px;}
.brand-name{font-weight:900; color:#0B6B43; font-size:26px; letter-spacing:0.5px; line-height:1.1; margin:0; text-align:center;}
.brand-tagline{font-size:9.5px; color:#168B57; font-weight:700; letter-spacing:0.4px; margin-top:4px; text-align:center;}
.footer{position:fixed; bottom:-66px; left:0; right:0; height:64px; border-top:2.5px solid #168B57; text-align:center; font-size:9px; color:#6B7280; padding-top:0; background:#fff;}
.footer-address{font-size:11px; font-weight:700; color:#1F2937; margin-top:5px; text-align:center;}
.footer-contact{margin:5px 14px 0; background:#DBEAFE; border-top:1.5px solid #168B57; border-bottom:1.5px solid #168B57; padding:4px 8px; font-size:9.5px; color:#1F2937; font-weight:700;}
.footer-sep{color:#168B57; margin:0 10px;}
.title{background:#168B57; color:#fff; display:inline-block; padding:5px 16px; font-weight:800; font-size:13px; letter-spacing:1px; margin:8px 0;}
.box{border:1.5px solid #1F2937; padding:10px; margin:8px 0;}
.meta{width:100%; border-collapse:collapse; font-size:10.5px; border:1.5px solid #1F2937;}
.meta td{border:1px solid #1F2937; padding:6px 8px; height:22px;}
.meta-label{background:#EAF7F0; font-weight:700; width:140px; border:1px solid #1F2937;}
.items{width:100%; border-collapse:collapse; border:1.5px solid #1F2937; margin-top:10px;}
.items th{background:#0B6B43; color:#fff; padding:7px 8px; font-size:10px; border:1px solid #1F2937; text-transform:uppercase;}
.items td{border:1px solid #1F2937; padding:7px 8px; height:22px; font-size:11px;}
.totals{width:280px; border-collapse:collapse; margin-left:auto; margin-top:10px; border:1.5px solid #1F2937;}
.totals td{border:1px solid #1F2937; padding:6px 8px; font-size:11px;}
.totals .label{background:#EAF7F0; font-weight:700;}
.grand{background:#0B6B43; color:#fff; font-weight:800;}
</style></head><body>
@php
  $labName=$lab->lab_name??'KRISHI ANALYTICAL LAB';
  $tagline=$lab->tagline??'Discovering Solutions, One Test at a Time';
  $addr=$lab->address??'182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701, Tiruppur Dist, Tamil Nadu';
  $phone=$lab->phone??'+91 63793 12357';
  $email=$lab->email??'info@krishianalyticallab.com';
  $gstin=$lab->gstin??'33AAAFK8921B1Z2';
  $logoPath=file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
@endphp
<div class="header">
  <div style="text-align:center;">
    @if(file_exists($logoPath))<img src="{{$logoPath}}" class="logo" alt="logo">@endif
    <div class="brand-block">
      <div class="brand-name">{{$labName}}</div>
      <div class="brand-tagline">"{{ $tagline }}"</div>
    </div>
  </div>
</div>
<div class="footer">
  <div class="footer-address">{{$addr}}@if($gstin) &nbsp;•&nbsp; GSTIN: {{$gstin}} @endif</div>
  <div class="footer-contact">
    <span>{{$email}}</span><span class="footer-sep">|</span><span>{{$phone}}</span><span class="footer-sep">|</span><span>+91 94433 12345</span>
  </div>
</div>

<div style="text-align:center;"><div class="title">TAX INVOICE</div><div style="text-align:right; font-size:9px;">Invoice No: <strong style="border:1px solid #1F2937; padding:2px 6px; font-family:monospace; font-size:11px;">{{$invoice->invoice_no}}</strong> <span style="margin-left:12px;">Date: {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</span></div><div style="text-align:right; font-size:8px; color:#6B7280;">Report: {{$report->report_no}} • {{$report->reportType->name}}</div></div>

<table class="meta">
<tr><td class="meta-label">Sample Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : '&nbsp;' }}</td><td class="meta-label">COA Date</td><td>{{ $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : '&nbsp;' }}</td></tr>
<tr><td class="meta-label">Party Name</td><td><strong>{{$invoice->party_name ?? $invoice->customer_name ?? $report->party_name ?? $report->customer_name ?? '&nbsp;'}}</strong></td><td class="meta-label">Sample Name</td><td>{{$report->sample_name ?? '&nbsp;'}}</td></tr>
<tr><td class="meta-label">Vehicle No</td><td>{{$report->vehicle_no ?? '&nbsp;'}}</td><td class="meta-label">Bill No</td><td>{{$report->bill_no ?? '&nbsp;'}}</td></tr>
<tr><td class="meta-label">Bags / Tons</td><td>{{$report->bags_tons ?? '&nbsp;'}}</td><td class="meta-label">Buyer</td><td>{{$report->buyer ?? '&nbsp;'}}</td></tr>
<tr><td class="meta-label">Seller</td><td>{{$report->seller ?? '&nbsp;'}}</td><td class="meta-label">Payment</td><td>{{ ucfirst($invoice->status) }}</td></tr>
<tr><td class="meta-label">Invoice Date</td><td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</td><td class="meta-label">Report No</td><td>{{$report->report_no}}</td></tr>
</table>

<table class="items">
<tr><th style="width:40px;">S.No</th><th>Test Parameter</th><th style="width:90px;">HSN</th><th style="width:100px;">Price (₹)</th></tr>
@foreach($report->results as $i => $res)
<tr><td style="text-align:center;">{{$i+1}}</td><td><strong>{{$res->parameter->name}}</strong> @if($res->parameter->unit) <span style="color:#6B7280;">({{$res->parameter->unit}})</span> @endif</td><td style="text-align:center;">{{$res->parameter->hsn_code ?? '-'}}</td><td style="text-align:right;">{{ number_format(floatval($res->parameter->price ?? 0),2) }}</td></tr>
@endforeach
</table>

<table class="totals">
<tr><td class="label">Subtotal</td><td style="text-align:right;">₹ {{ number_format($invoice->subtotal,2) }}</td></tr>
@if($invoice->gst_enabled)
<tr><td class="label">GST ({{ rtrim(rtrim(number_format($invoice->gst_percent,2), '0'), '.') }}%)</td><td style="text-align:right;">₹ {{ number_format($invoice->gst_amount,2) }}</td></tr>
@else
<tr><td class="label">GST</td><td style="text-align:center; color:#6B7280;">Disabled</td></tr>
@endif
<tr class="grand"><td>Total Amount</td><td style="text-align:right;">₹ {{ number_format($invoice->total_amount,2) }}</td></tr>
</table>

@if($invoice->gst_enabled && $gstin)
<div style="font-size:8px; color:#6B7280; margin-top:6px; text-align:right;">GSTIN: {{$gstin}} • HSN as per test • Round off as applicable</div>
@endif

<div style="border:1.5px solid #1F2937; margin-top:14px; padding:8px; min-height:46px;"><div style="font-size:9px; font-weight:800; color:#0B6B43; border-bottom:1px solid #1F2937; padding-bottom:4px; margin-bottom:6px;">Terms & Notes</div><div style="font-size:9px; color:#374151;">1. Payment within 7 days. 2. Tests as per standard methods. 3. Report valid for tested sample only.</div></div>

<div style="float:right; margin-top:30px; text-align:center; border:1px solid #1F2937; padding:10px 18px; min-width:170px;">
<div style="height:50px;"></div><div style="font-weight:800; font-size:10px; border-top:1.5px solid #1F2937; padding-top:4px;">Authorized Signatory</div><div style="font-size:8px; color:#6B7280;">KRISHI ANALYTICAL LAB</div>
</div>
</body></html>

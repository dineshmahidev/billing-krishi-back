<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head><meta charset="utf-8">
<style>
body{font-family:Arial,Helvetica,sans-serif; font-size:11pt; color:#1F2937; margin:20px;}
.header{border-bottom:2.5px solid #0B6B43; padding-bottom:8px; margin-bottom:12px; text-align:center;}
.logo{height:96px; width:96px; display:inline-block; vertical-align:middle;}
.brand-block{display:inline-block; vertical-align:middle; text-align:center; margin-left:10px;}
.brand-name{font-weight:900; color:#0B6B43; font-size:26pt; margin:0; text-align:center;}
.brand-tagline{font-size:9pt; color:#168B57; font-weight:700; margin-top:4px; text-align:center;}
.title{background:#168B57; color:#fff; display:inline-block; padding:6px 18px; font-weight:800; font-size:13pt; letter-spacing:1px; margin:8px 0;}
.meta{width:100%; border-collapse:collapse; margin:8px 0;}
.meta td{border:1.5px solid #1F2937; padding:6px 8px; height:22px;}
.meta-label{background:#EAF7F0; font-weight:700; width:150px; border:1.5px solid #1F2937;}
.items{width:100%; border-collapse:collapse; border:1.5px solid #1F2937; margin-top:8px;}
.items th{background:#0B6B43; color:#fff; border:1.5px solid #1F2937; padding:7px 8px; font-size:10pt;}
.items td{border:1.5px solid #1F2937; padding:7px 8px; height:22px;}
.totals{width:280px; border-collapse:collapse; margin-left:auto; margin-top:10px; border:1.5px solid #1F2937;}
.totals td{border:1.5px solid #1F2937; padding:6px 8px; font-size:11pt;}
.totals .label{background:#EAF7F0; font-weight:700;}
.grand{background:#0B6B43; color:#fff; font-weight:800;}
.outer{border:1.5px solid #1F2937; padding:10px; margin-top:8px;}
.terms{border:1.5px solid #1F2937; margin-top:14px; padding:8px; min-height:46px;}
.terms-h{font-size:9pt; font-weight:800; color:#0B6B43; border-bottom:1px solid #1F2937; padding-bottom:4px; margin-bottom:6px;}
.sig{border:1.5px solid #1F2937; float:right; width:200px; text-align:center; padding:8px; margin-top:30px;}
</style></head>
<body>
@php
  $labName = $lab->lab_name ?? 'KRISHI ANALYTICAL LAB';
  $tagline = $lab->tagline ?? 'Discovering Solutions, One Test at a Time';
  $address = $lab->address ?? '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701';
  $phone = $lab->phone ?? '+91 63793 12357';
  $email = $lab->email ?? 'info@krishianalyticallab.com';
  $gstin = $lab->gstin ?? '33AAAFK8921B1Z2';
  $logoW = file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
@endphp
<div class="header">
  <div style="text-align:center;">
    @if(file_exists($logoW))<img src="{{ $logoW }}" class="logo" alt="logo">@endif
    <div class="brand-block">
      <div class="brand-name">{{ $labName }}</div>
      <div class="brand-tagline">"{{ $tagline }}"</div>
    </div>
  </div>
</div>

<div style="text-align:center;">
  <div class="title">TAX INVOICE</div>
  <div style="text-align:right; font-size:9pt;">Invoice No: <strong style="border:1px solid #1F2937; padding:2px 8px; font-family:monospace;">{{ $invoice->invoice_no }}</strong> <span style="margin-left:12px;">Date: {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</span></div>
  <div style="text-align:right; font-size:8pt; color:#6B7280;">Report: {{ $report->report_no }} • {{ $report->reportType->name }}</div>
</div>

@php $companyI = $invoice->party_name ?? $invoice->customer_name ?? $report->party_name ?? $report->customer_name ?? ''; @endphp
<table class="meta">
<tr><td class="meta-label">Sample Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : '' }}&nbsp;</td><td class="meta-label">COA Date</td><td>{{ $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : '' }}&nbsp;</td></tr>
<tr><td class="meta-label">Party Name</td><td><strong>{{ $companyI }}</strong></td><td class="meta-label">Sample Name</td><td>{{ $report->sample_name }}&nbsp;</td></tr>
<tr><td class="meta-label">Vehicle No</td><td>{{ $report->vehicle_no }}&nbsp;</td><td class="meta-label">Bill No</td><td>{{ $report->bill_no }}&nbsp;</td></tr>
<tr><td class="meta-label">Bags / Tons</td><td>{{ $report->bags_tons }}&nbsp;</td><td class="meta-label">Buyer</td><td>{{ $report->buyer }}&nbsp;</td></tr>
<tr><td class="meta-label">Seller</td><td>{{ $report->seller }}&nbsp;</td><td class="meta-label">Payment</td><td>{{ ucfirst($invoice->status) }}</td></tr>
<tr><td class="meta-label">Invoice Date</td><td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</td><td class="meta-label">Report No</td><td>{{ $report->report_no }}</td></tr>
</table>

<table class="items">
<tr><th style="width:40px;">S.No</th><th>Test Parameter</th><th style="width:90px;">HSN</th><th style="width:100px;">Price (₹)</th></tr>
@foreach($report->results as $i => $res)
<tr><td style="text-align:center;">{{ $i+1 }}</td><td><strong>{{ $res->parameter->name }}</strong>@if($res->parameter->unit) <span style="color:#6B7280;">({{ $res->parameter->unit }})</span>@endif</td><td style="text-align:center;">{{ $res->parameter->hsn_code ?? '-' }}</td><td style="text-align:right;">{{ number_format(floatval($res->parameter->price ?? 0),2) }}</td></tr>
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
<div style="font-size:8pt; color:#6B7280; margin-top:6px; text-align:right;">GSTIN: {{ $gstin }} • HSN as per test • Round off as applicable</div>
@endif

<div class="terms">
  <div class="terms-h">Terms &amp; Notes</div>
  <div style="font-size:9pt; color:#374151;">1. Payment within 7 days. 2. Tests as per standard methods. 3. Report valid for tested sample only.</div>
</div>

<div class="sig"><div style="height:50px;">&nbsp;</div><div style="font-weight:800; border-top:1.5px solid #1F2937; padding-top:4px;">Authorized Signatory</div><div style="font-size:8pt; color:#6B7280;">KRISHI ANALYTICAL LAB</div></div>

<div style="clear:both; text-align:center; font-size:11pt; font-weight:700; color:#1F2937; margin-top:60px; border-top:2.5px solid #168B57; padding-top:6px;">{{ $address }}@if($gstin) &nbsp;•&nbsp; GSTIN: {{ $gstin }}@endif</div>
<div style="text-align:center; background:#DBEAFE; border-top:1.5px solid #168B57; border-bottom:1.5px solid #168B57; padding:4px 8px; margin:5px 14px 0; font-size:9.5pt; color:#1F2937; font-weight:700;">{{ $email }} | {{ $phone }} | +91 94433 12345</div>
</body></html>

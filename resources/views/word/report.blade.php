<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head><meta charset="utf-8">
<style>
body{font-family:Arial,Helvetica,sans-serif; font-size:11pt; color:#1F2937; margin:20px;}
.header{border-bottom:2.5px solid #0B6B43; padding-top:14px; padding-bottom:8px; margin-bottom:12px; text-align:center;}
.logo{height:96px; width:96px; display:inline-block; vertical-align:middle;}
.brand-block{display:inline-block; vertical-align:middle; text-align:center; margin-left:10px;}
.brand-name{font-weight:900; color:#0B6B43; font-size:26pt; margin:0; text-align:center;}
.brand-tagline{font-size:9pt; color:#168B57; font-weight:700; margin-top:4px; text-align:center;}
.title{background:#0B6B43; color:#fff; display:inline-block; padding:6px 18px; font-weight:800; font-size:13pt; letter-spacing:1px; margin:8px 0;}
.meta{width:100%; border-collapse:collapse; margin:8px 0;}
.meta td{border:1.5px solid #1F2937; padding:6px 8px; height:22px;}
.meta-label{background:#EAF7F0; font-weight:700; width:150px; border:1.5px solid #1F2937;}
.results{width:100%; border-collapse:collapse; border:1.5px solid #1F2937;}
.results th{background:#168B57; color:#fff; border:1.5px solid #1F2937; padding:7px 8px; font-size:10pt;}
.results td{border:1.5px solid #1F2937; padding:7px 8px; height:22px;}
.outer{border:1.5px solid #1F2937; padding:10px; margin-top:8px;}
.remarks{border:1.5px solid #1F2937; margin:12px 0; min-height:60px;}
.remarks-h{background:#EAF7F0; border-bottom:1.5px solid #1F2937; padding:4px 8px; font-weight:800; color:#0B6B43; font-size:9pt;}
.remarks-b{padding:8px 10px; min-height:36px;}
.sig{border:1.5px solid #1F2937; float:right; width:200px; text-align:center; padding:8px 10px 7px; margin-top:40px; min-height:86px;}
.sig-line{font-weight:800; border-top:1.5px solid #1F2937; margin-top:6px; padding-top:5px;}
.sig-sub{font-size:8pt; color:#6B7280; margin-top:2px;}
</style></head>
<body>
@php
  $labName = $lab->lab_name ?? 'KRISHI ANALYTICAL LAB';
  $tagline = $lab->tagline ?? 'Discovering Solutions, One Test at a Time';
  $address = $lab->address ?? '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701';
  $phone = $lab->phone ?? '+91 63793 12357';
  $email = $lab->email ?? 'info@krishianalyticallab.com';
  $reportTitle = $report->reportType->title ?? 'CERTIFICATE OF ANALYSIS';
  $isFeed = in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed']);
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
  <div class="title">{{ $reportTitle }}</div>
  <div style="text-align:right; font-size:9pt;">Report No: <strong style="border:1px solid #1F2937; padding:2px 8px; font-family:monospace;">{{ $report->report_no }}</strong></div>
</div>
<div class="outer">
@php $companyW = $report->party_name ?? $report->customer_name ?? ''; $showSpecW = $report->reportType->show_specification ?? true; $customColsW = $report->reportType->custom_columns ?? []; @endphp
<table class="meta">
<tr><td class="meta-label">Sample Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : '' }}&nbsp;</td><td class="meta-label">COA Date</td><td>{{ $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : '' }}&nbsp;</td></tr>
<tr><td class="meta-label">Party Name</td><td>{{ $companyW }}&nbsp;</td><td class="meta-label">Sample Name</td><td>{{ $report->sample_name }}&nbsp;</td></tr>
<tr><td class="meta-label">Vehicle No</td><td>{{ $report->vehicle_no }}&nbsp;</td><td class="meta-label">Bill No</td><td>{{ $report->bill_no }}&nbsp;</td></tr>
<tr><td class="meta-label">Bags / Tons</td><td>{{ $report->bags_tons }}&nbsp;</td><td class="meta-label">Buyer</td><td>{{ $report->buyer }}&nbsp;</td></tr>
<tr><td class="meta-label">Seller</td><td colspan="3">{{ $report->seller }}&nbsp;</td></tr>
</table>

<table class="results"><tr><th style="width:40px;">S.No</th><th>Parameters</th><th style="width:110px;">Result</th>@if($showSpecW)<th>Specification</th>@endif @foreach($customColsW as $col)<th>{{ $col }}</th>@endforeach</tr>
@foreach($report->results as $idx => $res)
<tr><td style="text-align:center;">{{ $idx+1 }}</td><td><strong>{{ $res->parameter->name }}</strong> @if($res->parameter->unit) ({{ $res->parameter->unit }}) @endif</td><td style="text-align:center; font-weight:700;">{{ $res->result }}&nbsp;</td>@if($showSpecW)<td>{{ $res->specification ?? $res->parameter->specification }}&nbsp;</td>@endif @foreach($customColsW as $col)<td>&nbsp;</td>@endforeach</tr>
@endforeach
@for($i = count($report->results); $i < 8; $i++)<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>@if($showSpecW)<td>&nbsp;</td>@endif @foreach($customColsW as $col)<td>&nbsp;</td>@endforeach</tr>@endfor
</table>
</div>

<div class="remarks"><div class="remarks-h">Remarks / Opinion:</div><div class="remarks-b">{{ $report->remarks }}&nbsp;</div></div>

<div class="sig"><div style="height:56px;">&nbsp;</div><div class="sig-line">Authorized Signatory</div><div class="sig-sub">KRISHI ANALYTICAL LAB</div></div>
<div style="clear:both; text-align:center; font-size:11pt; font-weight:700; color:#1F2937; margin-top:60px; border-top:2.5px solid #168B57; padding-top:6px;">{{ $address }}</div>
<div style="text-align:center; background:#DBEAFE; border-top:1.5px solid #168B57; border-bottom:1.5px solid #168B57; padding:4px 8px; margin:5px 14px 0; font-size:9.5pt; color:#1F2937; font-weight:700;">{{ $email }} | {{ $phone }} | +91 94433 12345</div>
</body></html>

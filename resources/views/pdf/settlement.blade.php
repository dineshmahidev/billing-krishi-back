<!DOCTYPE html><html><head><meta charset="utf-8"><style>
@page{size:A4 portrait; margin:168px 14px 70px 14px;}
*{font-family:Krishi,Helvetica,Arial,sans-serif; box-sizing:border-box;}
body{font-size:11px; color:#1F2937; margin:0;}
.header{position:fixed; top:-168px; left:0; right:0; height:144px; border-bottom:3px solid #0B6B43; background:#fff; padding:8px 14px; text-align:center;}
.header-group{width:100%; border-collapse:collapse;}
.header-group td{vertical-align:middle; padding:0; border:none;}
.logo{height:128px; width:128px; object-fit:contain; display:inline-block;}
.brand-block{display:block; width:100%; text-align:center;}
.brand-name{font-weight:bold; color:#0B6B43; font-size:36px; letter-spacing:0.5px; line-height:1.1; margin:0; text-align:center;}
.brand-tagline{font-size:14px; color:#374151; font-weight:bold; letter-spacing:0.5px; margin-top:6px; text-align:center;}
.footer{position:fixed; bottom:-56px; left:0; right:0; height:54px; border-top:2.5px solid #168B57; text-align:center; font-size:9px; color:#6B7280; padding-top:6px; background:#fff;}
.footer-address{font-size:10.5px; font-weight:700; color:#1F2937; margin-top:4px;}
.title{background:#EAF7F0; color:#0B6B43; display:inline-block; padding:5px 18px; font-weight:bold; font-size:13px; letter-spacing:1px; margin:6px 0 4px;}
.head-row{text-align:center;}
.meta{width:100%; border-collapse:collapse; font-size:10.5px; border:1.5px solid #1F2937; margin-top:6px;}
.meta td{border:1px solid #1F2937; padding:6px 8px; height:22px;}
.meta-label{background:#EAF7F0; font-weight:700; width:130px;}
.type{page-break-inside:avoid; margin-top:14px;}
.type-bar{background:#EAF7F0; color:#0B6B43; font-weight:bold; font-size:12px; padding:6px 10px; border:1.5px solid #1F2937; border-bottom:none;}
.type-bar .sub{float:right; font-size:11px;}
.items{width:100%; border-collapse:collapse; border:1.5px solid #1F2937;}
.items th{background:#EAF7F0; color:#1F2937; padding:6px 7px; font-size:9.5px; border:1px solid #1F2937; text-transform:uppercase;}
.items td{border:1px solid #1F2937; padding:6px 7px; height:21px; font-size:10.5px;}
.tot{background:#EAF7F0; color:#0B6B43; font-weight:bold; font-size:11px; border:1.5px solid #1F2937; border-top:none; text-align:right; padding:6px 10px;}
.grand{width:100%; border-collapse:collapse; margin-top:16px; border:1.5px solid #1F2937;}
.grand td{border:1px solid #1F2937; padding:8px 10px; font-size:12px;}
.grand .lbl{background:#F3F4F6; font-weight:700; width:60%;}
.grand .val{background:#EAF7F0; color:#0B6B43; font-weight:bold; font-size:14px; text-align:right;}
.note{border:1.5px solid #1F2937; margin-top:14px; padding:8px; font-size:9.5px; color:#374151;}
.note b{color:#0B6B43;}
.right{text-align:right;}
.signature-area{position:absolute; bottom:26px; right:14px; width:200px; text-align:center; page-break-inside:avoid;}
.sig-img{height:64px; width:auto; max-width:170px; object-fit:contain; display:block; margin:0 auto 4px auto;}
.sig-line{border-top:1.5px solid #1F2937; margin-top:6px; padding-top:5px; font-weight:bold; font-size:11px; color:#1F2937;}
.sig-sub{font-size:9px; color:#6B7280; margin-top:2px;}
</style></head><body>
@php
  $labName=$lab->lab_name??'KRISHI ANALYTICAL LAB';
  $tagline=$lab->tagline??'Discovering Solutions, One Test at a Time';
  $addr=$lab->address??'Kangeyam, Tiruppur';
  $phone=$lab->phone??'';
  $email=$lab->email??'';
  $gstin=$lab->gstin??'';
  $logoPath=file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
  $fmt = function($v){ $v = round(floatval($v), 2); return (fmod($v, 1) == 0) ? number_format($v, 0) : number_format($v, 2); };
  $scopeName = $data['scope']==='group'
      ? ($data['group']->name ?? 'Group')
      : ($data['customer']->company_name ?? ($data['customer']->name ?? 'Party'));
@endphp
<div class="header">
  <table class="header-group">
    <tr>
      <td style="width:150px; text-align:left;">@if(file_exists($logoPath))<img src="{{ $logoPath }}" class="logo" alt="logo">@endif</td>
      <td class="brand-block">
        <div class="brand-name">{{ $labName }}</div>
        <div class="brand-tagline">"{{ $tagline }}"</div>
      </td>
    </tr>
  </table>
</div>
<div class="footer">
  <div class="footer-address">{{ $addr }}@if($gstin) &nbsp;•&nbsp; GSTIN: {{ $gstin }} @endif</div>
  <div>{{ $email }} @if($email && $phone) | @endif {{ $phone }}</div>
</div>

<div class="head-row">
  <div class="title">SETTLEMENT BILL{{ $data['edited'] ? ' (EDITED)' : '' }}</div>
  <div style="font-size:9px; color:#6B7280;">Generated: {{ now()->format('d-M-Y H:i') }}</div>
</div>

<table class="meta">
  <tr>
    <td class="meta-label">{{ $data['scope']==='group' ? 'Group' : 'Party' }}</td>
    <td><strong>{{ $scopeName }}</strong></td>
    <td class="meta-label">Duration</td>
    <td><strong>{{ \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y') }} to {{ \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y') }}</strong></td>
  </tr>
  <tr>
    <td class="meta-label">Type-wise Bills</td>
    <td>{{ count($data['types']) }} type(s)</td>
    <td class="meta-label">Reports</td>
    <td>{{ $data['report_count'] }}</td>
  </tr>
</table>

@php $no = 0; @endphp
@foreach($data['types'] as $type)
<div class="type">
  <div class="type-bar">{{ strtoupper($type['name']) }} — BILL
    <span class="sub">{{ $type['reports'] }} report(s) &nbsp;•&nbsp; Subtotal ₹ {{ $fmt($type['subtotal']) }}</span>
  </div>
  <table class="items">
    <tr>
      <th style="width:34px;">S.No</th>
      <th>Test Parameter</th>
      <th style="width:56px;">Unit</th>
      <th style="width:52px;">Times</th>
      <th style="width:76px;">Rate (₹)</th>
      <th style="width:52px;">Qty</th>
      <th style="width:92px;">Amount (₹)</th>
    </tr>
    @foreach($type['rows'] as $i => $row)
      @php $no++; @endphp
      <tr>
        <td style="text-align:center;">{{ $i+1 }}</td>
        <td><strong>{{ $row['name'] }}</strong></td>
        <td style="text-align:center;">{{ $row['unit'] ?: '-' }}</td>
        <td style="text-align:center;">{{ $row['times'] }}</td>
        <td style="text-align:right;">{{ $fmt($row['rate']) }}</td>
        <td style="text-align:center;">{{ $row['qty'] }}</td>
        <td style="text-align:right;">{{ $fmt($row['amount']) }}</td>
      </tr>
    @endforeach
  </table>
  <div class="tot">Type Total — {{ strtoupper($type['name']) }} &nbsp;&nbsp; ₹ {{ $fmt($type['subtotal']) }}</div>
</div>
@endforeach

<table class="grand">
  <tr>
    <td class="lbl">GRAND TOTAL ({{ count($data['types']) }} type-wise bills, {{ $data['report_count'] }} reports)</td>
    <td class="val">₹ {{ $fmt($data['grand_total']) }}</td>
  </tr>
</table>

<div class="note">
  <b>Notes:</b> 1. Rate &amp; Qty as per edited settlement screen{{ $data['edited'] ? ' (edited values applied)' : '' }}.
  2. Times = number of times the parameter was tested by this party in the duration.
  3. Amount = Rate × Qty. 4. This is a settlement statement, not a tax invoice.
</div>

<div class="signature-area">
  @php $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null; @endphp
  @if($sigPath)<img src="{{ $sigPath }}" class="sig-img" alt="signature">@else<div style="height:52px;">&nbsp;</div>@endif
  <div class="sig-line">Authorized Signatory</div>
  <div class="sig-sub">KRISHI ANALYTICAL LAB</div>
</div>
</body></html>

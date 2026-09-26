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
.items{width:100%; border-collapse:collapse; border:1.5px solid #1F2937; margin-top:14px;}
.items th{background:#EAF7F0; color:#1F2937; padding:7px; font-size:9.5px; border:1px solid #1F2937; text-transform:uppercase;}
.items td{border:1px solid #1F2937; padding:7px; height:22px; font-size:10.5px;}
.items tr.tot td{background:#EAF7F0; font-weight:bold;}
.badge{font-size:9.5px; font-weight:700;}
.paid{color:#168B57;}
.unpaid{color:#DC2626;}
.partial{color:#B45309;}
.cards{width:100%; border-collapse:collapse; margin-top:14px;}
.cards td{border:1.5px solid #1F2937; padding:8px 10px; text-align:center; width:25%;}
.cards .lbl{background:#EAF7F0; font-size:9.5px; font-weight:700; text-transform:uppercase; color:#6B7280;}
.cards .val{font-size:15px; font-weight:bold; color:#0B6B43;}
.grand{width:100%; border-collapse:collapse; margin-top:14px; border:1.5px solid #1F2937;}
.grand td{border:1px solid #1F2937; padding:8px 10px; font-size:12px;}
.grand .lbl{background:#F3F4F6; font-weight:700;}
.grand .val{background:#EAF7F0; color:#0B6B43; font-weight:bold; font-size:14px; text-align:right;}
.note{border:1.5px solid #1F2937; margin-top:14px; padding:8px; font-size:9.5px; color:#374151;}
.note b{color:#0B6B43;}
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
  $title = $data['scope']==='group' ? 'GROUP SUMMARY' : 'PARTY SUMMARY';
  $balance = round($data['totals']['amount'] - $data['totals']['paid_amount'], 2);
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
  <div class="title">{{ $title }}</div>
  <div style="font-size:9px; color:#6B7280;">Generated: {{ now()->format('d-M-Y H:i') }}</div>
</div>

<table class="meta">
  <tr>
    <td class="meta-label">{{ $data['scope']==='group' ? 'Group' : 'Party' }}</td>
    <td><strong>{{ $scopeName }}</strong></td>
    <td class="meta-label">Duration</td>
    <td><strong>{{ \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y') }} to {{ \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y') }}</strong></td>
  </tr>
</table>

<table class="cards">
  <tr>
    <td><div class="lbl">Parties</div><div class="val">{{ count($data['rows']) }}</div></td>
    <td><div class="lbl">Invoices</div><div class="val">{{ $data['totals']['invoices'] }}</div></td>
    <td><div class="lbl">Total Billed</div><div class="val">₹ {{ $fmt($data['totals']['amount']) }}</div></td>
    <td><div class="lbl">Received</div><div class="val">₹ {{ $fmt($data['totals']['paid_amount']) }}</div></td>
  </tr>
</table>

<table class="items">
  <tr>
    <th style="width:34px;">S.No</th>
    <th>Party</th>
    <th style="width:62px;">Invoices</th>
    <th style="width:62px;">Paid</th>
    <th style="width:62px;">Unpaid</th>
    <th style="width:62px;">Partial</th>
    <th style="width:96px;">Amount (₹)</th>
    <th style="width:96px;">Received (₹)</th>
  </tr>
  @foreach($data['rows'] as $i => $row)
  <tr>
    <td style="text-align:center;">{{ $i+1 }}</td>
    <td><strong>{{ $row['party'] }}</strong></td>
    <td style="text-align:center;">{{ $row['invoices'] }}</td>
    <td style="text-align:center;"><span class="badge paid">{{ $row['paid'] }}</span></td>
    <td style="text-align:center;"><span class="badge unpaid">{{ $row['unpaid'] }}</span></td>
    <td style="text-align:center;"><span class="badge partial">{{ $row['partial'] }}</span></td>
    <td style="text-align:right;">{{ $fmt($row['amount']) }}</td>
    <td style="text-align:right;">{{ $fmt($row['paid_amount']) }}</td>
  </tr>
  @endforeach
  <tr class="tot">
    <td colspan="2">TOTAL</td>
    <td style="text-align:center;">{{ $data['totals']['invoices'] }}</td>
    <td colspan="3"></td>
    <td style="text-align:right;">{{ $fmt($data['totals']['amount']) }}</td>
    <td style="text-align:right;">{{ $fmt($data['totals']['paid_amount']) }}</td>
  </tr>
</table>

<table class="grand">
  <tr>
    <td class="lbl" style="width:60%;">Outstanding (Billed − Received)</td>
    <td class="val">₹ {{ $fmt($balance) }}</td>
  </tr>
</table>

<div class="note">
  <b>Notes:</b> 1. Invoice dates considered between the selected duration.
  2. Paid = invoices with status Paid; Partial = part payment received.
  3. Amounts as per generated invoices (incl. GST).
</div>

<div class="signature-area">
  @php $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null; @endphp
  @if($sigPath)<img src="{{ $sigPath }}" class="sig-img" alt="signature">@else<div style="height:52px;">&nbsp;</div>@endif
  <div class="sig-line">Authorized Signatory</div>
  <div class="sig-sub">KRISHI ANALYTICAL LAB</div>
</div>
</body></html>

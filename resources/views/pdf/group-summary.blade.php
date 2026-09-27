<!DOCTYPE html><html><head><meta charset="utf-8"><style>
@page{size:A4 portrait; margin:160px 14px 76px 14px;}
*{font-family:Krishi,Helvetica,Arial,sans-serif; box-sizing:border-box;}
body{font-size:11px; color:#1F2937; margin:0;}
.header{position:fixed; top:-160px; left:0; right:0; height:140px; border-bottom:3px solid #0B6B43; background:#fff; padding:4px 10px 8px 10px; text-align:center;}
.header-group{margin:0 auto; border-collapse:collapse;}
.header-group td{vertical-align:middle; padding:0; border:none;}
.logo{height:104px; width:104px; object-fit:contain; display:block; margin:0 auto;}
.logo-kla{font-weight:900; font-size:13.5px; color:#0B6B43; letter-spacing:2.5px; text-align:center; margin-top:1px; line-height:1;}
.brand-block{text-align:left; padding-left:16px;}
.brand-name{font-weight:900; color:#0B6B43; font-size:32px; letter-spacing:0.8px; line-height:1.1; margin:0; text-align:left; text-transform:uppercase;}
.brand-tagline{font-size:13px; color:#1F2937; font-weight:bold; font-style:italic; letter-spacing:0.5px; margin-top:4px; text-align:left;}
.footer{position:fixed; bottom:-62px; left:0; right:0; height:58px; border-top:2.5px solid #168B57; text-align:center; font-size:9px; color:#6B7280; padding-top:0; background:#fff;}
.footer-address{font-size:10px; font-weight:700; color:#1F2937; margin-top:4px; text-align:center;}
.footer-contact{margin:4px 14px 0; background:#EAF7F0; border-top:1px solid #A7D7C1; border-bottom:1px solid #A7D7C1; padding:2.5px 8px; font-size:9px; color:#1F2937; font-weight:700;}
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
.sig-container{width:100%; margin-top:28px; page-break-inside:avoid; clear:both;}
.signature-area{float:right; width:200px; text-align:center; page-break-inside:avoid;}
.sig-img{height:64px; width:auto; max-width:170px; object-fit:contain; display:block; margin:0 auto 4px auto;}
.sig-line{border-top:1.5px solid #1F2937; margin-top:6px; padding-top:5px; font-weight:bold; font-size:11px; color:#1F2937;}
.sig-sub{font-size:9px; color:#6B7280; margin-top:2px;}
</style></head><body>
@php
  $labName=$lab->lab_name??'KRISHI ANALYTICAL LAB';
  $tagline=$lab->tagline??'Discovering Solutions, One Test at a Time';
  $addr=$lab->address??'182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701';
  $phone='+91 63793 12357, +91 88838 64756';
  $email=$lab->email??'krishianalyticallab@gmail.com';
  $website=$lab->website?:'https://krishilab25.in';
  $websiteLabel=preg_replace('#^https?://#i', '', $website);
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
  <table class="header-group" align="center">
    <tr>
      <td style="text-align:center; vertical-align:middle;">
        @if(file_exists($logoPath))
          <img src="{{ $logoPath }}" class="logo" alt="logo">
          <div class="logo-kla">KLA</div>
        @endif
      </td>
      <td class="brand-block" style="vertical-align:middle;">
        <div class="brand-name">{{ $labName }}</div>
        <div class="brand-tagline">“{{ $tagline }}”</div>
      </td>
    </tr>
  </table>
</div>
<div class="footer">
  <div style="font-size:9px; font-weight:bold; color:#1F2937; padding-top:6px; line-height:1.3;">
    {{ $addr }}@if($gstin) &nbsp;&bull;&nbsp; GSTIN: {{ $gstin }} @endif &nbsp;&bull;&nbsp; Ph: {{ $phone }} &nbsp;&bull;&nbsp; {{ $email }} &nbsp;&bull;&nbsp; {{ $websiteLabel }}
  </div>
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

<div class="sig-container">
  <div class="signature-area">
    @php $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null; @endphp
    @if($sigPath)<img src="{{ $sigPath }}" class="sig-img" alt="signature">@else<div style="height:52px;">&nbsp;</div>@endif
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
        $y = $canvas->get_height() - 18;
        $canvas->text($x, $y, $text, $font, $size, array(0.42, 0.45, 0.5));
      }
    });
  }
</script>
</body></html>

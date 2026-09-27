<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 148px 14px 62px 14px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 11px; color: #1F2937; line-height: 1.4; margin: 0; background: #FFFFFF; }

.header {
  position: fixed;
  top: -148px;
  left: 0;
  right: 0;
  height: 136px;
  border-bottom: 3px solid #0B6B43;
  padding: 2px 10px 4px 10px;
  text-align: center;
  background: #FFFFFF;
}
.header-group { width: 100%; border-collapse: collapse; margin: 0; }
.header-group td { vertical-align: middle; padding: 0; border: none; }
.logo { height: 114px; width: 114px; object-fit: contain; display: block; margin: 0 auto; }
.logo-kla {
  font-weight: 900;
  font-size: 14.5px;
  color: #0B6B43;
  letter-spacing: 3px;
  text-align: center;
  margin-top: 1px;
  line-height: 1;
}
.brand-block { text-align: center; padding-left: 10px; padding-right: 10px; }
.brand-name {
  font-weight: 900;
  color: #0B6B43;
  font-size: 34px;
  letter-spacing: 0.5px;
  line-height: 1.1;
  margin: 0 auto;
  text-align: center;
  text-transform: uppercase;
}
.brand-tagline {
  font-size: 13.5px;
  color: #1F2937;
  font-weight: bold;
  font-style: italic;
  letter-spacing: 0.5px;
  margin-top: 4px;
  text-align: center;
}
.brand-address {
  font-size: 11px;
  font-weight: bold;
  color: #1F2937;
  margin-top: 5px;
  line-height: 1.35;
  text-align: center;
}

.footer {
  position: fixed;
  bottom: -56px;
  left: 0;
  right: 0;
  height: 52px;
  border-top: 2px solid #0B6B43;
  text-align: center;
  padding-top: 4px;
  background: #FFFFFF;
}
.footer-notes {
  font-size: 7.5px;
  color: #6B7280;
  text-align: center;
  line-height: 1.25;
}
.footer-sep { color: #9CA3AF; margin: 0 10px; }
.page-number { font-size: 8px; color: #6B7280; }

.watermark {
  position: fixed;
  bottom: 130px;
  right: 40px;
  opacity: 0.07;
  z-index: -1;
}
.watermark img { width: 180px; }

.title {
  background: #EAF7F0;
  color: #0B6B43;
  display: inline-block;
  padding: 5px 18px;
  font-weight: bold;
  font-size: 13px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin: 6px 0 6px 0;
}

.meta-table { width: 100%; border-collapse: collapse; margin: 4px 0 10px 0; font-size: 10.5px; border: 1.5px solid #1F2937; }
.meta-table td { padding: 6px 8px; border: 1px solid #1F2937; vertical-align: top; font-weight: 700; color: #1F2937; }
.meta-label { background: #EAF7F0; font-weight: bold; width: 110px; }

.stmt-table { width: 100%; border-collapse: collapse; margin-top: 2px; }
.stmt-table th { border-bottom: 1.5px solid #1F2937; padding: 4px 6px; font-size: 10px; font-weight: bold; text-align: left; background: #EAF7F0; }
.stmt-table td { padding: 3px 6px; font-size: 10px; vertical-align: top; border: none; }
.stmt-table tr:nth-child(even) td { background: #F9FAFB; }
.stmt-table .sno { width: 26px; text-align: left; }
.stmt-table .desc { text-align: left; }
.stmt-table .debit { width: 85px; text-align: right; }
.stmt-table .credit { width: 85px; text-align: right; }

.totals-section { width: 100%; border-top: 1.5px solid #1F2937; margin-top: 6px; padding-top: 4px; }
.totals-table { width: 100%; border-collapse: collapse; }
.totals-table td { padding: 2px 6px; font-size: 10px; font-weight: bold; border: none; }
.totals-table .lbl { text-align: left; padding-left: 26px; }
.totals-table .val-d { width: 85px; text-align: right; }
.totals-table .val-c { width: 85px; text-align: right; }

.bottom-container { width: 100%; margin-top: 24px; page-break-inside: avoid; clear: both; }
.bottom-table { width: 100%; border-collapse: collapse; }
.bottom-table td { vertical-align: bottom; border: none; padding: 0; }

.bal-box { border: 1.5px solid #D946EF; background: #fff; display: inline-block; }
.bal-lbl { border-right: 1.5px solid #D946EF; padding: 4px 8px; font-size: 10.5px; font-weight: bold; color: #C026D3; }
.bal-val { padding: 4px 10px; font-size: 10.5px; font-weight: bold; color: #C026D3; }

.sig-block { text-align: center; width: 190px; margin-left: auto; }
.sig-for { color: #0B6B43; font-weight: bold; font-size: 10px; margin-bottom: 4px; }
.sig-img { height: 48px; width: auto; max-width: 160px; object-fit: contain; display: block; margin: 0 auto 2px auto; }
.sig-signer { font-weight: bold; font-size: 10px; color: #111827; }
.sig-sub { font-size: 8.5px; color: #4B5563; }
.watermark {
  position: fixed;
  top: 32%;
  left: 50%;
  margin-left: -130px;
  width: 260px;
  text-align: center;
  opacity: 0.06;
  z-index: -1000;
}
.watermark img { width: 260px; }
</style>
</head>
<body>
@php
  $labName = $lab->lab_name ?? 'KRISHI ANALYTICAL LAB';
  $tagline = $lab->tagline ?? 'Discovering Solutions, One Test at a Time';
  $address = $lab->address ?? '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701';
  $phone = '+91 63793 12357, +91 88838 64756';
  $email = $lab->email ?? 'krishianalyticallab@gmail.com';
  $website = $lab->website ?: 'https://krishilab25.in';
  $websiteLabel = preg_replace('#^https?://#i', '', $website);
  $gstin = $lab->gstin ?? '';
  $logoPath = file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
  $fmt = function($v){ $v = round(floatval($v), 2); return number_format($v, 2); };
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;

  $custName = $data['customer_name'] ?? 'Party';
  $custAddr = $data['customer_address'] ?? '';
  $fromFormatted = \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y');
  $toFormatted = \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y');
@endphp

<div class="header">
  <table class="header-group">
    <tr>
      <td style="width: 120px; text-align: center; vertical-align: middle;">
        @if(file_exists($logoPath))
          <img src="{{ $logoPath }}" class="logo" alt="logo">
          <div class="logo-kla">KLA</div>
        @endif
      </td>
      <td class="brand-block" style="text-align: center; vertical-align: middle;">
        <div class="brand-name">{{ $labName }}</div>
        <div class="brand-tagline">“{{ $tagline }}”</div>
        <div class="brand-address">
          {{ $address }}@if($gstin) &nbsp;&bull;&nbsp; GSTIN: {{ $gstin }}@endif
        </div>
      </td>
    </tr>
  </table>
</div>

<div class="footer">
  <div style="font-size:9px; font-weight:bold; color:#111827; line-height:1.3;">
    Ph: {{ $phone }} &nbsp;&bull;&nbsp; {{ $email }} &nbsp;&bull;&nbsp; {{ $websiteLabel }}
  </div>
  <div class="footer-notes" style="margin-top:2px;">
    This is a computer generated statement of account.
  </div>
</div>

<div style="text-align:center;">
  <div class="title">CUSTOMER - ACCOUNT STATEMENT</div>
</div>

<table class="meta-table">
  <tr>
    <td class="meta-label">Customer / Party</td>
    <td>
      <div><strong>{{ $custName }}</strong></div>
      @if($custAddr)<div style="font-size:9.5px; color:#4B5563; margin-top:2px; font-weight:normal;">{!! nl2br(e($custAddr)) !!}</div>@endif
    </td>
    <td class="meta-label">Duration</td>
    <td style="width:140px;"><strong>{{ $fromFormatted }} to {{ $toFormatted }}</strong></td>
  </tr>
  @if(!empty($data['filter_types_label']))
  <tr>
    <td class="meta-label">Report Type</td>
    <td colspan="3"><span style="color:#0B6B43; font-weight:bold;">{{ $data['filter_types_label'] }}</span></td>
  </tr>
  @endif
</table>

<table class="stmt-table">
  <thead>
    <tr>
      <th class="sno">S.No</th>
      <th class="desc">Date &amp; Test Parameters / Description</th>
      <th class="debit">Debit (₹)</th>
      <th class="credit">Credit (₹)</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data['statement_rows'] as $row)
      <tr>
        <td class="sno">{{ $row['sno'] }}.</td>
        <td class="desc">
          @if($row['type'] === 'ob')
            <strong>O/B (Opening Balance)</strong>
          @else
            <span style="font-weight:bold; color:#0B6B43; margin-right:4px;">{{ $row['date'] }}</span>
            @if(!empty($row['company_name']))
              <strong style="color:#111827; font-size:10px; margin-right:4px;">[{{ $row['company_name'] }}]</strong>
            @endif
            <span>{{ $row['params_text'] }}</span>
            @if(!empty($row['vehicle_no']))
              <span style="color:#6B7280; font-size:9px;">({{ $row['vehicle_no'] }})</span>
            @endif
          @endif
        </td>
        <td class="debit">{{ $fmt($row['debit']) }}</td>
        <td class="credit">{{ $fmt($row['credit']) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="totals-section">
  <table class="totals-table">
    <tr>
      <td class="lbl">Net Total</td>
      <td class="val-d">{{ $fmt($data['totals']['total_debit']) }}</td>
      <td class="val-c">{{ $fmt($data['totals']['total_credit']) }}</td>
    </tr>
    <tr>
      <td class="lbl">Balance Outstanding</td>
      <td class="val-d" style="color:#0B6B43; font-size:11px;">₹ {{ $fmt($data['totals']['balance']) }}</td>
      <td class="val-c"></td>
    </tr>
  </table>
</div>

<div class="bottom-container">
  <table class="bottom-table">
    <tr>
      <td style="width:55%;">
        <div class="bal-box">
          <span class="bal-lbl">Balance Rs</span><span class="bal-val">₹ {{ $fmt($data['totals']['balance']) }}/-</span>
        </div>
      </td>
      <td style="width:45%; text-align:right;">
        <div class="sig-block">
          <div class="sig-for">For {{ $labName }}</div>
          @if($sigPath)
            <img src="{{ $sigPath }}" class="sig-img" alt="signature">
          @else
            <div style="height:48px;">&nbsp;</div>
          @endif
          <div class="sig-signer">Authorized Signatory</div>
          <div class="sig-sub">(Authorised Signatory)</div>
        </div>
      </td>
    </tr>
  </table>
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
</body>
</html>

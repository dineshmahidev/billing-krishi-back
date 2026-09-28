<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 14px 22px 56px 22px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 10.5px; color: #000000; line-height: 1.35; margin: 0; background: #ffffff; }

/* Header Section */
.header-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 6px;
}
.header-table td {
  vertical-align: middle;
  border: none;
  padding: 0;
}
.logo-box {
  width: 110px;
  text-align: left;
  vertical-align: middle;
}
.logo-img {
  height: 90px;
  width: 90px;
  object-fit: contain;
  display: block;
}
.logo-sub-text {
  font-size: 15px;
  font-weight: 900;
  color: #000000;
  letter-spacing: 4px;
  text-align: center;
  width: 90px;
  margin-top: 2px;
  line-height: 1;
}
.brand-center-box {
  text-align: center;
  padding: 0 10px;
}
.company-name {
  font-size: 29px;
  font-weight: 900;
  color: #0B6B43;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  margin: 0;
  line-height: 1.15;
}
.company-tagline {
  font-size: 13.5px;
  font-style: italic;
  font-weight: 700;
  color: #1F2937;
  letter-spacing: 0.4px;
  margin-top: 4px;
}

.right-balance-box {
  width: 110px;
}

/* Pure Clean Bold Black SETTLEMENT STATEMENT Title */
.report-title-container {
  text-align: center;
  margin: 8px 0 6px 0;
}
.report-main-title {
  font-size: 22px;
  font-weight: 900;
  color: #000000;
  letter-spacing: 3px;
  text-transform: uppercase;
  margin: 0;
  line-height: 1.2;
}

/* Top Meta Bar */
.top-meta-table {
  width: 100%;
  border-collapse: collapse;
  margin: 6px 0 6px 0;
  font-size: 11px;
}
.top-meta-table td {
  border: none;
  padding: 2px 0;
}

/* Customer & Statement Details 2-Column Section (Clean Borderless) */
.details-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 6px;
  font-size: 10.5px;
}
.details-table td {
  vertical-align: top;
  border: none;
  padding: 2.5px 2px;
}
.lbl-col {
  width: 125px;
  color: #000000;
  font-weight: 600;
}
.sep-col {
  width: 10px;
  text-align: center;
  font-weight: 600;
  color: #000000;
}
.val-col {
  color: #000000;
  font-weight: 700;
}

/* Statement Table */
.stmt-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 6px;
  border: 1.5px solid #000000;
}
.stmt-table th {
  background: #ffffff;
  color: #000000;
  padding: 5.5px 6px;
  font-size: 10.5px;
  font-weight: 900;
  text-align: left;
  border: 1px solid #000000;
  text-transform: uppercase;
}
.stmt-table td {
  border: 1px solid #000000;
  padding: 4.5px 6px;
  font-size: 10px;
  vertical-align: middle;
}

.totals-section {
  width: 100%;
  margin-top: 8px;
}
.totals-table {
  width: 100%;
  border-collapse: collapse;
  border: 1.5px solid #000000;
}
.totals-table td {
  border: 1px solid #000000;
  padding: 5px 8px;
  font-size: 11px;
  font-weight: bold;
}
.totals-table .lbl {
  text-align: left;
  background: #F9FAFB;
}

.bottom-container {
  width: 100%;
  margin-top: 14px;
  page-break-inside: avoid;
  clear: both;
}
.bottom-table {
  width: 100%;
  border-collapse: collapse;
}
.bottom-table td {
  vertical-align: middle;
  border: none;
  padding: 0;
}
.bal-box {
  border: 1.5px solid #000000;
  background: #ffffff;
  display: inline-block;
}
.bal-lbl {
  border-right: 1.5px solid #000000;
  padding: 5px 8px;
  font-size: 11px;
  font-weight: bold;
  background: #F9FAFB;
}
.bal-val {
  padding: 5px 10px;
  font-size: 12px;
  font-weight: 900;
  color: #0B6B43;
}

/* Signatory Section */
.sig-box {
  float: right;
  width: 200px;
  text-align: center;
}
.sig-img {
  height: 48px;
  width: auto;
  max-width: 160px;
  object-fit: contain;
  display: block;
  margin: 0 auto 3px auto;
}
.sig-name {
  font-weight: bold;
  font-size: 11px;
  color: #000000;
}
.sig-title {
  font-size: 10px;
  color: #374151;
  margin-top: 1px;
}

/* Static Bottom Pinned Footer */
.footer-pinned-container {
  position: fixed;
  bottom: -50px;
  left: 0;
  right: 0;
  width: 100%;
  border-top: 1px solid #000000;
  padding-top: 4px;
  text-align: center;
}
.footer-table {
  width: 100%;
  border-collapse: collapse;
  margin: 0 auto;
}
.footer-table td {
  text-align: center;
  border: none;
  padding: 1px 0;
  vertical-align: middle;
}
.footer-line-1 {
  font-size: 9.5px;
  font-weight: bold;
  color: #000000;
  text-align: center;
  line-height: 1.3;
}
.footer-line-2 {
  font-size: 9.5px;
  font-weight: bold;
  color: #000000;
  text-align: center;
  line-height: 1.3;
}
.footer-line-3 {
  font-size: 8.5px;
  color: #1F2937;
  text-align: center;
  line-height: 1.25;
}
.rupee {
  font-family: 'DejaVu Sans', sans-serif;
  font-weight: normal;
}
</style>
</head>
<body>
@php
  $logoPath = file_exists(public_path('krishi-transparent.png')) 
      ? public_path('krishi-transparent.png') 
      : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png'));
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;
  
  $fmt = function($v){ $v = round(floatval($v), 2); return number_format($v, 2); };
  $custName = $data['customer_name'] ?? 'Customer';
  $custAddr = $data['customer_address'] ?? '';
  $fromFormatted = \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y');
  $toFormatted = \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y');
  
  $phone = '+91 63793 12357, +91 88838 64756';
  if (!empty($lab->phone)) {
      $phone = str_contains($lab->phone, '88838') ? $lab->phone : $lab->phone . ', +91 88838 64756';
  }
  $email = $lab->email ?: 'krishianalyticallab@gmail.com';
  $website = $lab->website ?: 'www.krishilab25.in';
  $websiteClean = preg_replace('#^https?://#i', '', $website);
@endphp

<!-- Header: Left Logo + KAL | Center Company Name + Tagline -->
<table class="header-table">
  <tr>
    <td class="logo-box">
      @if(file_exists($logoPath))
        <img src="{{ $logoPath }}" class="logo-img" alt="KAL Logo">
        <div class="logo-sub-text">KAL</div>
      @endif
    </td>
    <td class="brand-center-box">
      <div class="company-name">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
      <div class="company-tagline">“{{ $lab->tagline ?? 'Discovering Solutions, One Test at a Time' }}”</div>
    </td>
    <td class="right-balance-box"></td>
  </tr>
</table>

<!-- Pure Clean Bold Black SETTLEMENT STATEMENT Title -->
<div class="report-title-container">
  <div class="report-main-title">CUSTOMER - ACCOUNT STATEMENT</div>
</div>

<!-- Customer & Statement Details (Two Columns Key-Value - NO BOX) -->
<table class="details-table">
  <tr>
    <!-- Left Column -->
    <td style="width: 55%; padding-right: 8px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col">Customer</td>
          <td class="sep-col">:</td>
          <td class="val-col">
            {{ $custName }}
          </td>
        </tr>
        @if(!empty($custAddr))
        <tr>
          <td class="lbl-col">Address</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $custAddr }}</td>
        </tr>
        @endif
        @if(!empty($data['filter_types_label']))
        <tr>
          <td class="lbl-col">Report Type</td>
          <td class="sep-col">:</td>
          <td class="val-col" style="color: #0B6B43;">{{ $data['filter_types_label'] }}</td>
        </tr>
        @endif
      </table>
    </td>

    <!-- Right Column -->
    <td style="width: 45%; padding-left: 8px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col" style="width: 90px;">Period</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $fromFormatted }} to {{ $toFormatted }}</td>
        </tr>
        <tr>
          <td class="lbl-col" style="width: 90px;">Statement Date</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ \Carbon\Carbon::now()->format('d-M-Y') }}</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- Statement Items Table -->
<table class="stmt-table">
  <thead>
    <tr>
      <th style="width: 34px; text-align: center;">S.No</th>
      <th>Date &amp; Test Parameters / Description</th>
      <th style="width: 85px; text-align: right;">Debit (<span class="rupee">&#8377;</span>)</th>
      <th style="width: 85px; text-align: right;">Credit (<span class="rupee">&#8377;</span>)</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data['statement_rows'] as $row)
      <tr>
        <td style="text-align: center;">{{ $row['sno'] }}.</td>
        <td>
          @if($row['type'] === 'ob')
            <strong>O/B (Opening Balance)</strong>
          @else
            <span style="font-weight: bold; color: #0B6B43; margin-right: 4px;">{{ $row['date'] }}</span>
            @if(!empty($row['company_name']))
              <strong style="color: #000000; font-size: 9.5px; margin-right: 4px;">[{{ $row['company_name'] }}]</strong>
            @endif
            <span>{{ $row['params_text'] }}</span>
            @if(!empty($row['vehicle_no']))
              <span style="color: #4B5563; font-size: 8.5px;">({{ $row['vehicle_no'] }})</span>
            @endif
          @endif
        </td>
        <td style="text-align: right;">{{ $fmt($row['debit']) }}</td>
        <td style="text-align: right;">{{ $fmt($row['credit']) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="totals-section">
  <table class="totals-table">
    <tr>
      <td class="lbl">Net Total</td>
      <td style="width: 85px; text-align: right;">{{ $fmt($data['totals']['total_debit']) }}</td>
      <td style="width: 85px; text-align: right;">{{ $fmt($data['totals']['total_credit']) }}</td>
    </tr>
    <tr>
      <td class="lbl">Balance Outstanding</td>
      <td colspan="2" style="text-align: right; color: #0B6B43; font-size: 11.5px; font-weight: 900;"><span class="rupee">&#8377;</span> {{ $fmt($data['totals']['balance']) }}</td>
    </tr>
  </table>
</div>

<div class="bottom-container">
  <table class="bottom-table">
    <tr>
      <td style="width: 55%;">
        <div class="bal-box">
          <span class="bal-lbl">Balance Rs</span><span class="bal-val"><span class="rupee">&#8377;</span> {{ $fmt($data['totals']['balance']) }}/-</span>
        </div>
      </td>
      <td style="width: 45%; text-align: right;">
        <div class="sig-box">
          @if($sigPath)
            <img src="{{ $sigPath }}" class="sig-img" alt="Signature">
          @else
            <div style="height: 48px;">&nbsp;</div>
          @endif
          <div class="sig-name">Authorized Signatory</div>
          <div class="sig-title">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
        </div>
      </td>
    </tr>
  </table>
</div>

<!-- Static Pinned Bottom Footer -->
<div class="footer-pinned-container">
  <table class="footer-table">
    <tr>
      <td class="footer-line-1">
        Address: {{ $lab->address ?? '182-B, Tiruppur Road, Kangeyam - 638701, Tamil Nadu, India.' }}
      </td>
    </tr>
    <tr>
      <td class="footer-line-2">
        Ph: {{ $phone }} &nbsp;&bull;&nbsp; Email: {{ $email }} &nbsp;&bull;&nbsp; Web: {{ $websiteClean }}
      </td>
    </tr>
    <tr>
      <td class="footer-line-3">
        Note: This is a computer-generated account statement.
      </td>
    </tr>
  </table>
</div>

<script type="text/php">
  if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
      if ($pageCount > 1) {
        $text = "Page " . $pageNumber . " of " . $pageCount;
        $size = 8;
        $font = $fontMetrics->getFont("Helvetica");
        $width = $fontMetrics->getTextWidth($text, $font, $size);
        $x = ($canvas->get_width() - $width) / 2;
        $y = $canvas->get_height() - 8;
        $canvas->text($x, $y, $text, $font, $size, array(0.12, 0.16, 0.22));
      }
    });
  }
</script>
</body>
</html>

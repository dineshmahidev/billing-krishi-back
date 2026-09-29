<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 12px 22px 70px 22px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body {
  font-size: 11px;
  color: #111827;
  line-height: 1.35;
  margin: 0;
  padding: 0;
  background: #ffffff;
}

/* Watermark Background */
.watermark-container {
  position: fixed;
  top: 240px;
  left: 0;
  right: 0;
  width: 100%;
  text-align: center;
  z-index: 9999;
  opacity: 0.048;
  pointer-events: none;
}
.watermark-img {
  width: 480px;
  height: auto;
  display: block;
  margin: 0 auto;
}

/* 1. Header Section (Arial Bold, 2x Prominence) */
.header-wrapper {
  width: 100%;
  text-align: center;
  margin-bottom: 6px;
  padding-top: 0;
}
.header-group-table {
  margin: 0 auto;
  border-collapse: collapse;
}
.header-group-table td {
  vertical-align: middle;
  border: none;
}
.logo-img {
  height: 110px;
  width: 110px;
  object-fit: contain;
  display: block;
  margin: 0 auto;
}
.header-green-bar {
  width: 3px;
  height: 96px;
  background-color: #0B6B43;
  margin: 0 auto;
}
.company-name {
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 38px;
  font-weight: 900;
  color: #0B6B43;
  letter-spacing: 1px;
  text-transform: uppercase;
  margin: 0;
  line-height: 1.05;
  text-align: center;
  white-space: nowrap;
}
.company-tagline {
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 15px;
  font-style: italic;
  font-weight: 800;
  color: #1F2937;
  letter-spacing: 0.4px;
  margin-top: 5px;
  line-height: 1.2;
  text-align: center;
}

/* 2. Section Badges with Side Lines */
.section-badge-table {
  width: 100%;
  margin: 12px 0 9px 0;
  border-collapse: collapse;
}
.section-badge-table td {
  padding: 0;
  border: none;
}
.badge-line {
  border-bottom: 1.2px solid #86C1A4;
  height: 1px;
  width: 100%;
}
.badge-pill-cell {
  width: 1%;
  white-space: nowrap;
  padding: 0 4px !important;
  vertical-align: middle;
}
.badge-pill {
  display: inline-block;
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 17.5px;
  font-weight: 900;
  color: #0B6B43;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  background-color: #EAF7F0;
  border: 1.5px solid #86C1A4;
  border-radius: 7px;
  padding: 6px 32px;
  line-height: 1.2;
  text-align: center;
}

/* 3. Customer & Statement Details Card */
.details-outer-box {
  width: 100%;
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  background-color: #F8FDF9;
  margin: 0 auto 8px auto;
  border-collapse: separate;
}
.details-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}
.details-table td {
  border: none;
  padding: 0;
  vertical-align: top;
}
.inner-meta-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}
.inner-meta-table td {
  border: none;
  padding: 2.5px 0;
  font-size: 13px;
  line-height: 1.3;
  vertical-align: top;
}
.lbl-col {
  color: #374151;
  font-weight: 700;
  font-size: 13px;
  white-space: nowrap;
  vertical-align: top;
}
.val-col {
  color: #000000;
  font-weight: 900;
  font-size: 13.5px;
  vertical-align: top;
  word-wrap: break-word;
  white-space: normal;
}
.colon-sep {
  display: inline-block;
  width: 14px;
  font-weight: 900;
  font-size: 13px;
  color: #000000;
  text-align: left;
  vertical-align: top;
}

.rupee {
  font-family: 'DejaVu Sans', sans-serif;
  font-weight: normal;
}

/* 4. Statement Table */
.stmt-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 4px;
  border: 1.5px solid #86C1A4;
}
.stmt-table th {
  background-color: #EAF7F0;
  color: #0B6B43;
  padding: 7px 10px;
  font-size: 14px;
  font-weight: 900;
  text-align: left;
  border: 1px solid #86C1A4;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  height: 28px;
}
.stmt-table td {
  border: 1px solid #D1E7DD;
  padding: 5px 8px;
  font-size: 12.5px;
  font-weight: 700;
  vertical-align: middle;
  color: #111827;
}
.stmt-table tbody tr:nth-child(even) {
  background-color: #F8FDF9;
}

/* 5. Totals & Balance Section */
.totals-section {
  width: 100%;
  margin-top: 6px;
}
.totals-table {
  width: 100%;
  border-collapse: collapse;
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  overflow: hidden;
}
.totals-table td {
  border: 1px solid #D1E7DD;
  padding: 6px 10px;
  font-size: 13px;
  font-weight: bold;
}
.totals-table .lbl {
  text-align: left;
  background-color: #EAF7F0;
  color: #0B6B43;
  font-weight: 800;
}

.bal-box {
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  background: #EAF7F0;
  display: inline-block;
  margin-top: 8px;
}
.bal-lbl {
  border-right: 1.5px solid #86C1A4;
  padding: 4px 8px;
  font-size: 11px;
  font-weight: 800;
  color: #0B6B43;
}
.bal-val {
  padding: 4px 10px;
  font-size: 12.5px;
  font-weight: 900;
  color: #0B6B43;
}

/* 6. End of Document Banner */
.end-report-banner {
  text-align: center;
  font-size: 11px;
  font-weight: 900;
  letter-spacing: 1.8px;
  margin: 6px 0 4px 0;
  color: #0B6B43;
}

/* 7. Signatory Section (Fixed Bottom Right - Above Footer Box with Bottom Margin) */
.sig-wrapper {
  position: fixed;
  bottom: 80px;
  right: 0px;
  width: 220px;
  z-index: 10;
}
.sig-box {
  width: 220px;
  text-align: center;
}
.sig-img {
  height: 42px;
  width: auto;
  max-width: 150px;
  object-fit: contain;
  display: block;
  margin: 0 auto 2px auto;
}
.sig-line {
  border-top: 1.5px solid #9CA3AF;
  width: 150px;
  margin: 2px auto 3px auto;
}
.sig-name {
  font-weight: 900;
  font-size: 13px;
  color: #111827;
}
.sig-title {
  font-weight: 800;
  font-size: 10.5px;
  color: #0B6B43;
  margin-top: 1px;
  text-transform: uppercase;
}

/* 8. Static Bottom Pinned Footer with Horizontal Box & Outside Note */
.footer-pinned-container {
  position: fixed;
  bottom: 0px;
  left: 0;
  right: 0;
  width: 100%;
  text-align: center;
}
.footer-box {
  width: 100%;
  border: 1.2px solid #000000;
  border-radius: 6px;
  background: transparent;
  padding: 4px 6px;
  margin: 0;
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
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 12.5px;
  font-weight: 800;
  color: #111827;
  text-align: center;
  line-height: 1.25;
}
.footer-line-2 {
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 12.5px;
  font-weight: 800;
  color: #0B6B43;
  text-align: center;
  line-height: 1.25;
}
.footer-note {
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 10px;
  font-weight: 700;
  color: #374151;
  text-align: center;
  line-height: 1.2;
  margin-top: 3px;
}
</style>
</head>
<body>
@php
  $watermarkPath = file_exists(public_path('krishi-transparent.png'))
      ? public_path('krishi-transparent.png')
      : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png'));
@endphp

<!-- Watermark Background Logo -->
@if(file_exists($watermarkPath))
<div class="watermark-container">
  <img src="{{ $watermarkPath }}" class="watermark-img" alt="Watermark">
</div>
@endif

@php
  $lab = $lab ?? \App\Models\LabSetting::first();
  $logoPath = file_exists(public_path('krishi-pdf-logo.png'))
      ? public_path('krishi-pdf-logo.png')
      : (file_exists(public_path('krishi-transparent.png'))
          ? public_path('krishi-transparent.png')
          : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png')));
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

<!-- 1. Header: Grouped Centered Logo + Vertical Green Line + Company Name & Tagline -->
<div class="header-wrapper">
  <table class="header-group-table" align="center">
    <tr>
      <td style="vertical-align: middle; text-align: center; padding-right: 16px; border: none;">
        @if(file_exists($logoPath))
          <img src="{{ $logoPath }}" class="logo-img" alt="Logo">
        @endif
      </td>
      <td style="vertical-align: middle; text-align: center; padding: 0 16px; width: 4px; border: none;">
        <div class="header-green-bar"></div>
      </td>
      <td style="vertical-align: middle; text-align: center; padding-left: 0; border: none;">
        <div class="company-name">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
        <div class="company-tagline">“{{ $lab->tagline ?? 'Discovering Solutions, One Test at a Time' }}”</div>
      </td>
    </tr>
  </table>
</div>

<!-- 2. Section 1 Badge: SETTLEMENT STATEMENT -->
<table class="section-badge-table" align="center">
  <tr>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    <td class="badge-pill-cell">
      <div class="badge-pill">SETTLEMENT STATEMENT</div>
    </td>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
  </tr>
</table>

<!-- 3. Customer & Statement Details Card -->
<table class="details-outer-box" align="center">
  <tr>
    <td style="padding: 12px 18px; border: none; vertical-align: top;">
      <table class="details-table" align="center">
        <tr>
          <!-- Left Column (55%) -->
          <td style="width: 55%; padding-right: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 110px;">
                <col style="width: auto;">
              </colgroup>
              @if(!empty($custName) && $custName !== '—')
              <tr>
                <td class="lbl-col">Customer</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $custName }}</td>
              </tr>
              @endif
              @if(!empty($custAddr))
              <tr>
                <td class="lbl-col">Address</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $custAddr }}</td>
              </tr>
              @endif
              @if(!empty($data['filter_types_label']))
              <tr>
                <td class="lbl-col">Report Type</td>
                <td class="val-col" style="color: #0B6B43;"><span class="colon-sep">:</span>{{ $data['filter_types_label'] }}</td>
              </tr>
              @endif
            </table>
          </td>
          
          <!-- Right Column (45%) -->
          <td style="width: 45%; padding-left: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 110px;">
                <col style="width: auto;">
              </colgroup>
              <tr>
                <td class="lbl-col">Period</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $fromFormatted }} to {{ $toFormatted }}</td>
              </tr>
              <tr>
                <td class="lbl-col">Statement Date</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ \Carbon\Carbon::now()->format('d-M-Y') }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- 4. Section 2 Badge: STATEMENT PARTICULARS -->
<table class="section-badge-table" align="center">
  <tr>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    <td class="badge-pill-cell">
      <div class="badge-pill">STATEMENT PARTICULARS</div>
    </td>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
  </tr>
</table>

<!-- 5. Statement Table -->
<table class="stmt-table">
  <thead>
    <tr>
      <th style="width: 40px; text-align: center;">S.No</th>
      <th>Date &amp; Test Parameters / Description</th>
      <th style="width: 105px; text-align: right;">Debit (<span class="rupee">&#8377;</span>)</th>
      <th style="width: 105px; text-align: right;">Credit (<span class="rupee">&#8377;</span>)</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data['statement_rows'] as $row)
      <tr>
        <td style="text-align: center; font-weight: 700;">{{ $row['sno'] }}</td>
        <td>
          @if($row['type'] === 'ob')
            <strong style="color: #0B6B43;">O/B (Opening Balance)</strong>
          @else
            <span style="font-weight: 800; color: #0B6B43; margin-right: 4px;">{{ $row['date'] }}</span>
            @if(!empty($row['company_name']))
              <strong style="color: #000000; font-size: 10px; margin-right: 4px;">[{{ $row['company_name'] }}]</strong>
            @endif
            <span>{{ $row['params_text'] }}</span>
            @if(!empty($row['vehicle_no']))
              <span style="color: #4B5563; font-size: 9.5px;">({{ $row['vehicle_no'] }})</span>
            @endif
          @endif
        </td>
        <td style="text-align: right; font-weight: 900; color: #000000;">{{ $fmt($row['debit']) }}</td>
        <td style="text-align: right; font-weight: 900; color: #000000;">{{ $fmt($row['credit']) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<!-- 6. Totals Section -->
<div class="totals-section">
  <table class="totals-table">
    <tr>
      <td class="lbl">Net Total</td>
      <td style="width: 105px; text-align: right; font-weight: 900; color: #000000;">{{ $fmt($data['totals']['total_debit']) }}</td>
      <td style="width: 105px; text-align: right; font-weight: 900; color: #000000;">{{ $fmt($data['totals']['total_credit']) }}</td>
    </tr>
    <tr>
      <td class="lbl">Balance Outstanding</td>
      <td colspan="2" style="text-align: right; color: #0B6B43; font-size: 14px; font-weight: 900;"><span class="rupee">&#8377;</span> {{ $fmt($data['totals']['balance']) }}</td>
    </tr>
  </table>
</div>

<div class="bal-box">
  <span class="bal-lbl">Balance Rs</span><span class="bal-val"><span class="rupee">&#8377;</span> {{ $fmt($data['totals']['balance']) }}/-</span>
</div>

<!-- 7. End of Statement Banner -->
<div class="end-report-banner">
  ************* End of Statement *************
</div>

<!-- 8. Signatory Block (Fixed Bottom Right - Above Footer Box with Bottom Margin) -->
<div class="sig-wrapper">
  <div class="sig-box">
    @if($sigPath)
      <img src="{{ $sigPath }}" class="sig-img" alt="Signature">
    @else
      <div style="height: 48px;">&nbsp;</div>
    @endif
    <div class="sig-line"></div>
    <div class="sig-name">Authorized Signatory</div>
    <div class="sig-title">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
  </div>
</div>

<!-- 9. Static Pinned Bottom Footer with Horizontal Box & Outside Note -->
<div class="footer-pinned-container">
  <div class="footer-box">
    <table class="footer-table">
      <tr>
        <td class="footer-line-1">
          <strong>Address:</strong> {{ $lab->address ?? '103-B, Tiruppur Road, Kangeyam - 638701, Tamil Nadu, India.' }}
        </td>
      </tr>
      <tr>
        <td class="footer-line-2">
          Ph: {{ $phone }} &nbsp;&bull;&nbsp; Email: {{ $email }} &nbsp;&bull;&nbsp; Web: {{ $websiteClean }}
        </td>
      </tr>
    </table>
  </div>
  <div class="footer-note">
    Note: This is a computer-generated account statement.
  </div>
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

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
body { font-size: 12px; color: #111827; line-height: 1.45; margin: 0; background: #FFFFFF; }

.header {
  position: fixed;
  top: -148px;
  left: 0;
  right: 0;
  height: 136px;
  border-bottom: 3px solid #0B6B43;
  padding: 2px 10px 4px 10px;
  text-align: center;
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
.footer-contact {
  font-size: 9px;
  font-weight: bold;
  color: #111827;
  line-height: 1.3;
}
.footer-sep { color: #9CA3AF; margin: 0 6px; }
.footer-notes {
  font-size: 7.5px;
  color: #374151;
  text-align: center;
  line-height: 1.25;
  margin-top: 2px;
}

/* Heading */
.heading-container {
  text-align: center;
  margin: 2px 0 6px 0;
  padding: 2px 0;
}
.main-title {
  font-weight: 900;
  font-size: 17.5px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #000000;
  line-height: 1.2;
}

.report-meta-bar {
  width: 100%;
  border-collapse: collapse;
  margin: 4px 0 4px 0;
}
.report-meta-bar td {
  border: none;
  padding: 0 0 2px 0;
  font-size: 11.5px;
  font-weight: 700;
  color: #000000;
}

/* Pure Black and White Meta Table - No background color, bold text */
.meta-table {
  width: 100%;
  border-collapse: collapse;
  margin: 2px 0 8px 0;
  font-size: 11.5px;
  border: 1.5px solid #000000;
}
.meta-table td {
  padding: 5.5px 8px;
  border: 1px solid #000000;
  height: 23px;
  vertical-align: middle;
  font-weight: 600;
  color: #000000;
  background: #FFFFFF;
}
.meta-label {
  font-weight: 900;
  width: 130px;
  color: #000000;
  background: #FFFFFF;
  text-transform: uppercase;
  font-size: 11px;
  letter-spacing: 0.5px;
}

/* Test Results Section Heading - matching CERTIFICATE OF ANALYSIS size */
.test-results-heading {
  font-size: 17.5px;
  font-weight: 900;
  color: #000000;
  letter-spacing: 2px;
  text-transform: uppercase;
  margin: 8px 0 4px 0;
  text-align: center;
  border-top: 1.5px solid #000000;
  border-bottom: 1.5px solid #000000;
  padding: 3px 0;
  background: #FFFFFF;
  line-height: 1.2;
}

/* Clean Black and White Results Table - No background color, bold header */
.results-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 2px;
}
.results-table th {
  background: #FFFFFF;
  color: #000000;
  padding: 6px 8px;
  font-size: 11.5px;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-top: 1.5px solid #000000;
  border-bottom: 1.5px solid #000000;
  border-left: none;
  border-right: none;
  text-align: left;
}
.results-table td {
  padding: 5.5px 8px;
  font-size: 12px;
  vertical-align: middle;
  border: none;
  color: #000000;
  background: #FFFFFF;
}
.results-table-container {
  width: 100%;
  border-bottom: 1.5px solid #000000;
  margin-bottom: 8px;
}

/* End of Report */
.end-of-report {
  text-align: center;
  font-weight: 900;
  font-size: 11px;
  letter-spacing: 2.5px;
  margin: 8px 0 6px 0;
  color: #000000;
}

/* Bottom Block: Notes & Signature */
.bottom-block {
  width: 100%;
  border-collapse: collapse;
  margin-top: 8px;
  page-break-inside: avoid;
}
.bottom-block td {
  border: none;
  padding: 0;
}
.notes-container {
  font-size: 9px;
  color: #111827;
  line-height: 1.35;
  padding-right: 15px;
}
.notes-title {
  font-weight: 800;
  font-size: 9.5px;
  text-decoration: underline;
  margin-bottom: 2px;
  color: #111827;
}
.notes-list {
  margin: 0;
  padding-left: 14px;
}
.notes-list li {
  margin-bottom: 1px;
}

.sig-block {
  text-align: center;
  width: 180px;
  margin-left: auto;
}
.sig-for {
  color: #111827;
  font-weight: bold;
  font-size: 10px;
  margin-bottom: 3px;
}
.sig-img {
  height: 44px;
  width: auto;
  max-width: 150px;
  object-fit: contain;
  display: block;
  margin: 0 auto 2px auto;
}
.sig-signer {
  font-weight: bold;
  font-size: 10px;
  color: #111827;
}
.sig-sub {
  font-size: 8.5px;
  color: #4B5563;
}
.page-number { font-size: 7px; color: #6B7280; }
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
  $reportTypeTitle = $report->reportType?->title ?: ($report->reportType?->name ? $report->reportType->name . ' - TEST REPORT' : 'TEST REPORT');
  $logoPath = file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;
  $companyAll = $report->party_name ?? $report->customer_name ?? '';
  $sampleDateFormatted = $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : \Carbon\Carbon::parse($report->created_at)->format('d-M-Y');
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
        <div class="brand-address">{{ $address }}</div>
      </td>
    </tr>
  </table>
</div>

<div class="footer">
  <div class="footer-contact">
    Ph: {{ $phone }}<span class="footer-sep">&bull;</span>{{ $email }}<span class="footer-sep">&bull;</span>{{ $websiteLabel }}
  </div>
  <div class="footer-notes">
    <strong>Note:</strong> 1. The results relate only to the sample tested. &nbsp;&bull;&nbsp; 2. This report shall not be reproduced, except in full, without written approval of the laboratory. &nbsp;&bull;&nbsp; 3. Tested samples retained for 15 days from report date.
  </div>
</div>

<div class="heading-container">
  <div class="main-title">CERTIFICATE OF ANALYSIS</div>
</div>

<table class="report-meta-bar">
  <tr>
    <td style="text-align: left;">Date: <strong>{{ $sampleDateFormatted }}</strong></td>
    <td style="text-align: right;">Report No: <strong style="font-family: monospace; font-size: 12.5px;">{{ $report->report_no }}</strong></td>
  </tr>
</table>

<table class="meta-table">
  <tr>
    <td class="meta-label">Party Name</td>
    <td>
      {!! $companyAll ? e($companyAll) : '&nbsp;' !!}
      @if($report->customer?->group?->name)
        <span style="font-size: 10px; font-weight: normal; color: #4B5563; margin-left: 4px;">(Group: {{ $report->customer->group->name }})</span>
      @endif
    </td>
    <td class="meta-label">Sample Name</td>
    <td>{!! $report->sample_name ? e($report->sample_name) : '&nbsp;' !!}</td>
  </tr>
  <tr>
    <td class="meta-label">Vehicle No</td>
    <td>{!! $report->vehicle_no ? e($report->vehicle_no) : '&nbsp;' !!}</td>
    <td class="meta-label">Bill No</td>
    <td>{!! $report->bill_no ? e($report->bill_no) : '&nbsp;' !!}</td>
  </tr>
  <tr>
    <td class="meta-label">{{ $report->reportType?->quantity_label ?: 'Tons / Bags' }}</td>
    <td colspan="3">{!! $report->bags_tons ? e($report->bags_tons) : '&nbsp;' !!}</td>
  </tr>
</table>

<div class="test-results-heading">TEST RESULTS</div>

@php
  $showSpec = $report->reportType->show_specification ?? true;
  $customCols = $report->reportType->custom_columns ?? [];
  $rows = $report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)->values();
@endphp

<div class="results-table-container">
  <table class="results-table">
    <thead>
      <tr>
        <th style="width: 34px; text-align:left;">S.No</th>
        <th>Test Parameters / Description</th>
        <th style="width: 120px; text-align:center;">Result</th>
        @if($showSpec)<th style="text-align:left;">Specification</th>@endif
        @foreach($customCols as $col)<th style="text-align:left;">{{ $col }}</th>@endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $idx => $res)
      <tr>
        <td style="text-align:left; color:#111827; font-weight:bold;">{{ $idx+1 }}.</td>
        <td>
          <span style="font-weight:700; color:#111827;">{{ $res->parameter->name ?? 'Parameter' }}</span>
          @if($res->parameter->unit && $res->parameter->unit !== '%')<span style="color:#4B5563; font-weight:normal;"> ({{ $res->parameter->unit }})</span>@endif
        </td>
        <td style="text-align:center; font-weight:800; color:#111827; font-size:12.5px;">{!! ($res->result && $res->result !== '-') ? e($res->result) . (($res->parameter->unit ?? '') === '%' && !str_contains($res->result, '%') ? ' %' : '') : '—' !!}</td>
        @if($showSpec)<td style="color:#111827;">{!! ($res->specification ?? $res->parameter->specification) ? e($res->specification ?? $res->parameter->specification) : '—' !!}</td>@endif
        @foreach($customCols as $col)<td style="color:#111827;">—</td>@endforeach
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="end-of-report">*** END OF REPORT ***</div>

<div class="sig-container" style="width: 100%; margin-top: 14px; page-break-inside: avoid; clear: both;">
  <div class="sig-block" style="text-align: center; width: 190px; margin-left: auto;">
    <div class="sig-for" style="color: #111827; font-weight: bold; font-size: 10.5px; margin-bottom: 3px;">For KRISHI ANALYTICAL LAB</div>
    @if($sigPath)
      <img src="{{ $sigPath }}" class="sig-img" alt="signature" style="height: 48px; width: auto; max-width: 160px; object-fit: contain; display: block; margin: 0 auto 2px auto;">
    @else
      <div style="height: 48px;">&nbsp;</div>
    @endif
    <div class="sig-signer" style="font-weight: bold; font-size: 10.5px; color: #111827;">Authorized Signatory</div>
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
</body>
</html>

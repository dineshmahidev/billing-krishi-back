<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 18px 24px 20px 24px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 10px; color: #111827; line-height: 1.35; margin: 0; background: #ffffff; }

/* Header */
.header-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 8px;
}
.header-table td {
  vertical-align: middle;
  border: none;
  padding: 0;
}
.logo-img {
  height: 65px;
  width: auto;
  max-width: 90px;
  object-fit: contain;
  display: block;
}
.company-name {
  font-size: 18px;
  font-weight: 900;
  color: #0B6B43;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 4px;
}
.report-main-title {
  font-size: 14px;
  font-weight: 800;
  color: #1F2937;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  text-align: center;
}

/* Top Meta Bar */
.top-meta-table {
  width: 100%;
  border-collapse: collapse;
  margin: 10px 0 6px 0;
  font-size: 10px;
}
.top-meta-table td {
  border: none;
  padding: 1.5px 0;
}

/* Customer & Sample Details 2-Column Section */
.details-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 8px;
  font-size: 9.5px;
}
.details-table td {
  vertical-align: top;
  border: none;
  padding: 2.5px 2px;
}
.lbl-col {
  width: 145px;
  color: #1F2937;
  font-weight: 600;
}
.sep-col {
  width: 12px;
  text-align: center;
  font-weight: 600;
  color: #1F2937;
}
.val-col {
  color: #111827;
  font-weight: 700;
  font-style: italic;
}

/* Section Title */
.section-title {
  text-align: center;
  font-size: 11px;
  font-weight: 900;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: #111827;
  margin: 6px 0 4px 0;
  padding: 2px 0;
}

/* Test Results Table */
.results-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 2px;
  border: 1px solid #111827;
}
.results-table th {
  background: #ffffff;
  color: #111827;
  padding: 4.5px 5px;
  font-size: 9.5px;
  font-weight: 800;
  text-align: left;
  border: 1px solid #111827;
}
.results-table td {
  padding: 4px 5px;
  font-size: 9.5px;
  border: 1px solid #111827;
  vertical-align: middle;
  color: #111827;
}
.results-table tr.category-row td {
  font-weight: 800;
  background: #ffffff;
  padding: 3.5px 5px;
}

/* Note and End of Report */
.customer-info-note {
  font-size: 8.5px;
  font-weight: normal;
  color: #374151;
  margin-top: 4px;
}
.customer-info-note em {
  font-weight: bold;
  font-style: italic;
}
.end-report-banner {
  text-align: center;
  font-size: 9.5px;
  font-weight: 700;
  letter-spacing: 1.5px;
  margin: 10px 0 6px 0;
  color: #111827;
}

/* Signatory Section */
.sig-wrapper {
  width: 100%;
  margin-top: 14px;
  page-break-inside: avoid;
  clear: both;
}
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
  font-size: 10px;
  color: #1F2937;
}
.sig-title {
  font-size: 9.5px;
  font-weight: 700;
  color: #0284C7;
  margin-top: 1px;
}

/* Footer Section */
.footer-disclaimer-container {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  border-top: 1px solid #111827;
  padding-top: 4px;
  font-size: 7.5px;
  color: #374151;
  line-height: 1.25;
}
.footer-lab-address {
  font-weight: bold;
  color: #111827;
  margin-bottom: 2px;
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
  
  $customerName = $report->party_name ?: ($report->customer_name ?: ($report->customer?->company_name ?: ($report->customer?->name ?: '—')));
  $customerAddress = $report->customer?->address ?: ($report->customer?->city ? $report->customer->city . ($report->customer?->pincode ? ' - ' . $report->customer->pincode : '') : 'Kangeyam, Tamil Nadu');
  $sampleDateFormatted = $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d M Y') : \Carbon\Carbon::parse($report->created_at)->format('d M Y');
  $coaDateFormatted = $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d M Y') : $sampleDateFormatted;
  
  $rows = $report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)->values();
@endphp

<!-- Header -->
<table class="header-table">
  <tr>
    <td style="width: 85px; text-align: left;">
      @if(file_exists($logoPath))
        <img src="{{ $logoPath }}" class="logo-img" alt="KAL Logo">
      @endif
    </td>
    <td style="text-align: center;">
      <div class="company-name">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
      <div class="report-main-title">TEST REPORT</div>
    </td>
    <td style="width: 85px; text-align: right;">
      <!-- No badge as requested -->
      &nbsp;
    </td>
  </tr>
</table>

<!-- Top Meta Bar (Report No, Page, Report Date) -->
<table class="top-meta-table">
  <tr>
    <td style="text-align: left; width: 60%;">
      Report No &nbsp;: &nbsp;<strong>{{ $report->report_no }}</strong>
    </td>
    <td style="text-align: right; width: 40%;">
      Report Date &nbsp;: &nbsp;<strong>{{ $coaDateFormatted }}</strong>
    </td>
  </tr>
</table>

<!-- Customer & Sample Details (Two Columns Key-Value) -->
<table class="details-table">
  <tr>
    <!-- Left Column -->
    <td style="width: 54%; padding-right: 10px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col">Customer Name</td>
          <td class="sep-col">:</td>
          <td class="val-col">M/s. {{ $customerName }}</td>
        </tr>
        <tr>
          <td class="lbl-col">Customer Address</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $customerAddress }}</td>
        </tr>
        <tr>
          <td class="lbl-col">Sample Name/Description</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $report->sample_name ?: ($report->reportType?->name ?: 'Sample') }}</td>
        </tr>
        <tr>
          <td class="lbl-col">Sample Condition</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $report->nature_of_sample ?: 'Fit for Analysis' }}</td>
        </tr>
        <tr>
          <td class="lbl-col">Reference</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $report->bill_no ? 'Bill No: ' . $report->bill_no : 'Test Request Form' }}</td>
        </tr>
        <tr>
          <td class="lbl-col">Sample Identification</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $report->vehicle_no ? 'Vehicle No: ' . $report->vehicle_no : 'NA' }}</td>
        </tr>
        <tr>
          <td class="lbl-col">Sampling Details</td>
          <td class="sep-col">:</td>
          <td class="val-col">Sample not drawn by Laboratory</td>
        </tr>
      </table>
    </td>
    
    <!-- Right Column -->
    <td style="width: 46%; padding-left: 6px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col" style="width: 120px;">Sample Quantity</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $report->bags_tons ?: '1 Sample' }}</td>
        </tr>
        <tr>
          <td class="lbl-col" style="width: 120px;">Sample Received on</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $sampleDateFormatted }}</td>
        </tr>
        <tr>
          <td class="lbl-col" style="width: 120px;">Test Started on</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $sampleDateFormatted }}</td>
        </tr>
        <tr>
          <td class="lbl-col" style="width: 120px;">Test Completed on</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $coaDateFormatted }}</td>
        </tr>
        @if($report->buyer || $report->seller)
        <tr>
          <td class="lbl-col" style="width: 120px;">Buyer / Seller</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ trim(($report->buyer ? 'Buyer: '.$report->buyer : '') . ($report->seller ? ' / Seller: '.$report->seller : '')) }}</td>
        </tr>
        @endif
      </table>
    </td>
  </tr>
</table>

<!-- Section Title -->
<div class="section-title">TEST RESULTS</div>

<!-- Results Table -->
<table class="results-table">
  <thead>
    <tr>
      <th style="width: 36px; text-align: center;">S.No</th>
      <th style="width: 220px; text-align: left;">Parameter</th>
      <th style="text-align: left;">Test Method</th>
      <th style="width: 75px; text-align: center;">Unit</th>
      <th style="width: 85px; text-align: center;">Results</th>
    </tr>
  </thead>
  <tbody>
    <tr class="category-row">
      <td colspan="5" style="border: 1px solid #111827; background: #ffffff;">
        {{ $report->reportType?->name ? $report->reportType->name . ' - Chemical' : 'Chemical' }}
      </td>
    </tr>
    @foreach($rows as $idx => $res)
    @php
      $param = $res->parameter;
      $method = $res->specification ?: ($param->specification ?: ($param->name === 'Free Fatty Acid' ? 'FSSAI / IS 548 (Part 1) - 2021' : ($param->name === 'Oil Content' ? 'IS 548 (Part 1/ Section 2) - 2021' : 'IS / Standard Method')));
      $unit = $param->unit ?: ($param->short_code === 'FFA' || $param->short_code === 'OC' ? '%' : '--');
    @endphp
    <tr>
      <td style="text-align: center;">{{ $idx + 1 }}</td>
      <td><strong>{{ $param->name ?? 'Parameter' }}</strong></td>
      <td>{{ $method }}</td>
      <td style="text-align: center;">{{ $unit }}</td>
      <td style="text-align: center; font-weight: bold; font-size: 10.5px;">
        {{ ($res->result !== null && $res->result !== '') ? $res->result : '—' }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<!-- Under Table Notes -->
<div class="customer-info-note">
  Note: <em>Information provided by the customer is indicated in Bold &amp; Italics.</em>
</div>

<div class="end-report-banner">
  /************* End of the Report *************/
</div>

<!-- Signatory Block -->
<div class="sig-wrapper">
  <div class="sig-box">
    @if($sigPath)
      <img src="{{ $sigPath }}" class="sig-img" alt="Authorized Signature">
    @else
      <div style="height: 48px;">&nbsp;</div>
    @endif
    <div class="sig-name">R. Iyappan</div>
    <div class="sig-title">Authorized Signatory-Chemical</div>
  </div>
</div>

<!-- Footer / Disclaimer -->
<div class="footer-disclaimer-container">
  <div class="footer-lab-address">
    Laboratory Address: {{ $lab->address ?? '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701, Tamil Nadu, India.' }}
    @if(!empty($lab->email)) &nbsp;&bull;&nbsp; Email: {{ $lab->email }} @endif
    @if(!empty($lab->phone)) &nbsp;&bull;&nbsp; Ph: {{ $lab->phone }} @endif
  </div>
  <div>
    Note: Test results relate only to the items tested. Test Report shall not be reproduced in full or part without the approval of the laboratory. Any corrections shall invalidate this test report. Unless otherwise agreed with customer, remnant non-perishable samples are disposed of 15 days after receipt, while perishable and environmental samples are discarded immediately upon test completion. Samples are not drawn by laboratory unless otherwise stated. A satisfactory test report in no way implies that a product so tested is approved by any agency.
  </div>
</div>

<script type="text/php">
  if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
      $text = "Page " . $pageNumber . " of " . $pageCount;
      $size = 8;
      $font = $fontMetrics->getFont("Helvetica");
      $width = $fontMetrics->getTextWidth($text, $font, $size);
      $x = $canvas->get_width() - $width - 24;
      $y = 48;
      $canvas->text($x, $y, $text, $font, $size, array(0.12, 0.16, 0.22));
    });
  }
</script>
</body>
</html>

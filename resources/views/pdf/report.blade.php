<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 12px 20px 48px 20px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 10.5px; color: #000000; line-height: 1.35; margin: 0; background: #ffffff; }

/* Header Section */
.header-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 4px;
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
  height: 85px;
  width: 85px;
  object-fit: contain;
  display: block;
}
.logo-sub-text {
  font-size: 14px;
  font-weight: 900;
  color: #000000;
  letter-spacing: 4px;
  text-align: center;
  width: 85px;
  margin-top: 1px;
  line-height: 1;
}
.brand-center-box {
  text-align: center;
  padding: 0 10px;
}
.company-name {
  font-size: 34px;
  font-weight: 900;
  color: #0B6B43;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  margin: 0;
  line-height: 1.12;
}
.company-tagline {
  font-size: 13px;
  font-style: italic;
  font-weight: 700;
  color: #1F2937;
  letter-spacing: 0.4px;
  margin-top: 3px;
}

.right-balance-box {
  width: 110px;
}

/* Pure Clean Bold Black CERTIFICATE OF ANALYSIS Title - No shades / No box */
.report-title-container {
  text-align: center;
  margin: 6px 0 4px 0;
}
.report-main-title {
  font-size: 21px;
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
  margin: 3px 0 5px 0;
  font-size: 11px;
  font-weight: bold;
}
.top-meta-table td {
  border: none;
  padding: 1px 0;
  font-weight: bold;
  color: #000000;
}

/* Customer & Sample Details 2-Column Section */
.details-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 5px;
  table-layout: fixed;
}
.details-table td {
  vertical-align: top;
  border: none;
  padding: 0;
}
.inner-meta-table {
  width: 100%;
  border-collapse: collapse;
}
.inner-meta-table td {
  border: none;
  padding: 2px 0;
  vertical-align: top;
  font-size: 10.5px;
  font-weight: bold;
  color: #000000;
  line-height: 1.3;
}
.lbl-col {
  width: 95px;
  max-width: 95px;
  white-space: nowrap;
  font-weight: bold;
  color: #000000;
  font-size: 10.5px;
}
.sep-col {
  width: 8px;
  max-width: 8px;
  text-align: left;
  white-space: nowrap;
  font-weight: bold;
  color: #000000;
  font-size: 10.5px;
  padding: 2px 0;
}
.val-col {
  font-weight: bold;
  color: #000000;
  font-size: 10.5px;
  word-wrap: break-word;
  padding-left: 2px;
}

/* Pure Clean Bold Black TEST RESULTS Section Title */
.section-title-container {
  text-align: center;
  margin: 10px 0 12px 0;
}
.section-title {
  font-size: 17px;
  font-weight: 900;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #000000;
  margin: 0;
  line-height: 1.2;
}

/* Test Results Table - Snug Fit to Content */
.results-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 3px;
  border: 1.2px solid #000000;
}
.results-table th {
  background: #ffffff;
  color: #000000;
  padding: 4px 5px;
  font-size: 10px;
  font-weight: 900;
  text-align: left;
  border: 1px solid #000000;
  text-transform: uppercase;
}
.results-table td {
  padding: 3.5px 5px;
  font-size: 10px;
  border: 1px solid #000000;
  vertical-align: middle;
  color: #000000;
}

/* Note and End of Report */
.customer-info-note {
  text-align: center;
  font-size: 9.5px;
  font-weight: normal;
  color: #1F2937;
  margin-top: 6px;
}
.customer-info-note em {
  font-weight: bold;
}
.end-report-banner {
  text-align: center;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 1.5px;
  margin: 8px 0 5px 0;
  color: #000000;
}

/* Signatory Section */
.sig-wrapper {
  width: 100%;
  margin-top: 10px;
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
  bottom: -42px;
  left: 0;
  right: 0;
  width: 100%;
  border-top: 1px solid #000000;
  padding-top: 3px;
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
</style>
</head>
<body>
@php
  $logoPath = file_exists(public_path('krishi-pdf-logo.png'))
      ? public_path('krishi-pdf-logo.png')
      : (file_exists(public_path('krishi-transparent.png'))
          ? public_path('krishi-transparent.png')
          : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png')));
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;
  
  $customerName = $report->party_name ?: ($report->customer_name ?: ($report->customer?->company_name ?: ($report->customer?->name ?: '—')));
  $matchedCustomer = $report->customer ?: ($report->customer_id ? \App\Models\Customer::find($report->customer_id) : \App\Models\Customer::where('name', $customerName)->orWhere('company_name', $customerName)->first());
  $customerAddress = $report->address ?: ($matchedCustomer?->address ?: ($matchedCustomer?->city ? $matchedCustomer->city . ($matchedCustomer?->pincode ? ' - ' . $matchedCustomer->pincode : '') : ''));
  
  $sampleDateFormatted = $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : ($report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('d-M-Y') : '—');
  $coaDateFormatted = $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : $sampleDateFormatted;
  
  $showSpec = $report->reportType->show_specification ?? true;
  $customCols = $report->reportType->custom_columns ?? [];
  $quantityLabel = $report->reportType?->quantity_label ?: 'Quantity (Bags / Tons)';
  
  $phone = '+91 63793 12357, +91 88838 64756';
  if (!empty($lab->phone)) {
      $phone = str_contains($lab->phone, '88838') ? $lab->phone : $lab->phone . ', +91 88838 64756';
  }
  $email = $lab->email ?: 'krishianalyticallab@gmail.com';
  $website = $lab->website ?: 'www.krishilab25.in';
  $websiteClean = preg_replace('#^https?://#i', '', $website);
  
  $rows = $report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)->values();
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

<!-- Pure Clean Bold Black TEST REPORT Title -->
<div class="report-title-container">
  <div class="report-main-title">TEST REPORT</div>
</div>

<!-- Top Meta Bar (Report No opposite Report Date with bottom margin) -->
<table class="top-meta-table">
  <tr>
    <td style="text-align: left; width: 50%;">
      Report No &nbsp;: &nbsp;{{ $report->report_no }}
    </td>
    <td style="text-align: right; width: 50%;">
      Report Date &nbsp;: &nbsp;{{ $coaDateFormatted }}
    </td>
  </tr>
</table>

<!-- Customer & Sample Details (Snug 50/50 Columns Key-Value - Straight Vertical Colon Alignment) -->
<table class="details-table">
  <tr>
    <!-- Left Column (50%) -->
    <td style="width: 50%; padding-right: 12px; vertical-align: top;">
      <table class="inner-meta-table">
        <tr>
          <td width="95" class="lbl-col">Party / Customer</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">
            {{ $customerName }}
            @if($report->customer?->group?->name)
              <span style="font-weight: bold; font-size: 10px; color: #374151;">({{ $report->customer->group->name }})</span>
            @endif
          </td>
        </tr>
        <tr>
          <td width="95" class="lbl-col">Address</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $customerAddress ?: '—' }}</td>
        </tr>
        @if(!empty($report->sample_name))
        <tr>
          <td width="95" class="lbl-col">Sample Name</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->sample_name }}</td>
        </tr>
        @endif
        <tr>
          <td width="95" class="lbl-col">Nature of Sample</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->nature_of_sample ?: ($report->sample_name ?: ($report->reportType?->name ?: 'Sample')) }}</td>
        </tr>
        @if(!empty($report->bill_no))
        <tr>
          <td width="95" class="lbl-col">Bill No</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->bill_no }}</td>
        </tr>
        @endif
        @if(!empty($report->vehicle_no))
        <tr>
          <td width="95" class="lbl-col">Vehicle No</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->vehicle_no }}</td>
        </tr>
        @endif
      </table>
    </td>
    
    <!-- Right Column (50%) -->
    <td style="width: 50%; padding-left: 12px; vertical-align: top;">
      <table class="inner-meta-table">
        @if(!empty($report->bags_tons))
        <tr>
          <td width="95" class="lbl-col">{{ $quantityLabel }}</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->bags_tons }}</td>
        </tr>
        @endif
        <tr>
          <td width="95" class="lbl-col">Sample Date</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $sampleDateFormatted }}</td>
        </tr>
        @if(!empty($report->buyer))
        <tr>
          <td width="95" class="lbl-col">Buyer</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->buyer }}</td>
        </tr>
        @endif
        @if(!empty($report->seller))
        <tr>
          <td width="95" class="lbl-col">Seller</td>
          <td width="8" class="sep-col">:</td>
          <td class="val-col">{{ $report->seller }}</td>
        </tr>
        @endif
      </table>
    </td>
  </tr>
</table>

<!-- Pure Clean Bold Black TEST RESULTS Section Title -->
<div class="section-title-container">
  <div class="section-title">TEST RESULTS</div>
</div>

@php
  $tableCols = $report->reportType?->table_columns;
  if (!is_array($tableCols) || empty($tableCols)) {
    $tableCols = [
      ['key' => 's_no', 'label' => 'S.No', 'visible' => true, 'type' => 'system'],
      ['key' => 'parameter', 'label' => 'Parameter', 'visible' => true, 'type' => 'system'],
    ];
    if ($showSpec) {
      $tableCols[] = ['key' => 'specification', 'label' => 'Specification', 'visible' => true, 'type' => 'system'];
    }
    foreach ($customCols as $cIdx => $cName) {
      $tableCols[] = ['key' => 'custom_' . $cIdx, 'label' => $cName, 'visible' => true, 'type' => 'custom'];
    }
    $tableCols[] = ['key' => 'result', 'label' => 'Result', 'visible' => true, 'type' => 'system'];
  }
  $activeTableCols = array_values(array_filter($tableCols, fn($c) => ($c['visible'] ?? true) !== false));
@endphp

<!-- Results Table -->
<table class="results-table">
  <thead>
    <tr>
      @foreach($activeTableCols as $col)
        @php
          $ckey = $col['key'] ?? '';
          $clabel = $col['label'] ?? '';
          $isSno = ($ckey === 's_no');
          $isResult = ($ckey === 'result');
          $isSpec = ($ckey === 'specification');
          $isCustom = str_starts_with($ckey, 'custom_');

          $thStyle = 'text-align: left;';
          if ($isSno) {
            $thStyle = 'width: 38px; text-align: center;';
          } elseif ($isResult) {
            $thStyle = 'width: 22%; text-align: center;';
          } elseif ($isSpec) {
            $thStyle = 'width: 26%; text-align: left;';
          } elseif ($isCustom) {
            $thStyle = 'width: 18%; text-align: left;';
          }
        @endphp
        <th style="{{ $thStyle }}">
          {{ $clabel }}
        </th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach($rows as $idx => $res)
    @php
      $param = $res->parameter;
      $spec = $res->specification ?: ($param->specification ?: '—');
      $resultVal = ($res->result !== null && $res->result !== '') ? $res->result : '—';
    @endphp
    <tr>
      @foreach($activeTableCols as $col)
        @php
          $ckey = $col['key'] ?? '';
          $clabel = $col['label'] ?? '';
        @endphp
        @if($ckey === 's_no')
          <td style="text-align: center;">{{ $idx + 1 }}</td>
        @elseif($ckey === 'parameter')
          <td><strong>{{ $param->name ?? 'Parameter' }}</strong></td>
        @elseif($ckey === 'specification')
          <td>{{ $spec }}</td>
        @elseif($ckey === 'result')
          <td style="text-align: center; font-weight: bold; font-size: 11px;">
            {{ $resultVal }}
          </td>
        @else
          @php
            $cVal = '';
            if (is_array($res->custom_values)) {
              $cVal = $res->custom_values[$clabel] ?? ($res->custom_values[$ckey] ?? '');
            }
          @endphp
          <td>{{ $cVal !== '' ? $cVal : '—' }}</td>
        @endif
      @endforeach
    </tr>
    @endforeach
  </tbody>
</table>

@if(!empty($report->remarks))
<div style="margin: 8px 0 6px 0; padding: 4px 8px; background-color: #F9FAFB; border-left: 3px solid #0B6B43; font-size: 10.5px; line-height: 1.4;">
  <strong style="color: #0B6B43;">Remarks / Notes:</strong> <span style="font-weight: 600; color: #111827;">{{ $report->remarks }}</span>
</div>
@endif

<div class="end-report-banner">
  /************* End of the Report *************/
</div>

<!-- Signatory Block -->
<div class="sig-wrapper">
  <div class="sig-box">
    @if($sigPath)
      <img src="{{ $sigPath }}" class="sig-img" alt="Signature">
    @else
      <div style="height: 48px;">&nbsp;</div>
    @endif
    <div class="sig-name">Authorized Signatory</div>
    <div class="sig-title">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
  </div>
</div>

<!-- Static Pinned Bottom Footer (All 3 lines fully displayed and centered) -->
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
        Note: Test results relate only to the items tested. Test Report shall not be reproduced in full or part without the approval of the laboratory. Any corrections shall invalidate this test report.
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

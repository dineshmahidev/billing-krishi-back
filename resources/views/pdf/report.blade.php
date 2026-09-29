<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 14px 28px 75px 28px;
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

/* Watermark Background (Huge Centered Light Logo, Fixed Non-Wrapping Overlay with Highest z-index) */
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

/* 1. Centered Grouped Header Section (Arial Bold, 2x Prominence) */
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
.logo-sub-text {
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 16px;
  font-weight: 900;
  color: #000000;
  letter-spacing: 6px;
  text-align: center;
  width: 110px;
  margin-top: 3px;
  line-height: 1;
}
.header-green-bar {
  width: 3px;
  height: 96px;
  background-color: #0B6B43;
  margin: 0 auto;
}
.company-name {
  font-family: 'Arial', 'Helvetica', sans-serif;
  font-size: 40px;
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
  font-size: 16px;
  font-style: italic;
  font-weight: 800;
  color: #1F2937;
  letter-spacing: 0.4px;
  margin-top: 5px;
  line-height: 1.2;
  text-align: center;
}

/* 2. Section Badges with Clean Seamless Flanking Lines & Smooth Light Green Pill */
.badge-wrapper {
  width: 100%;
  margin-top: 14px;
  margin-bottom: 14px;
  padding: 0;
}
.section-badge-table {
  width: 100%;
  border-collapse: collapse;
  margin: 0;
}
.section-badge-table td {
  vertical-align: middle;
  border: none;
  padding: 0;
}
.badge-line {
  border-bottom: 1.2px solid #86C1A4;
  height: 1px;
  width: 100%;
}
.badge-pill-cell {
  width: 1%;
  white-space: nowrap;
  text-align: center;
  padding: 0 4px;
}
.badge-pill {
  font-family: 'Arial', 'Helvetica', sans-serif;
  background-color: #EAF7F0;
  color: #0B6B43;
  border: 1.5px solid #86C1A4;
  padding: 6px 34px;
  font-size: 18.5px;
  font-weight: 900;
  letter-spacing: 2.5px;
  border-radius: 6px;
  text-transform: uppercase;
  display: inline-block;
  line-height: 1.2;
  white-space: nowrap;
}

/* 3. Customer & Sample Details Card (Centered Columns & Balanced Margins, Pixel-Perfect Alignment) */
.details-outer-box {
  margin: 0 auto;
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  background-color: #F8FDF9;
}
.details-table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
  margin: 0 auto;
}
.details-table td {
  vertical-align: top;
  border: none;
  padding: 0;
}
.inner-meta-table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}
.inner-meta-table td {
  border: none;
  padding: 2.5px 0;
  vertical-align: top;
  font-size: 13.5px;
  line-height: 1.3;
}
.lbl-col {
  white-space: nowrap;
  font-weight: 700;
  color: #374151;
  font-size: 13.5px;
}
.val-col {
  font-weight: 900;
  color: #000000;
  font-size: 14.5px;
  word-wrap: break-word;
  padding-left: 0;
}
.colon-sep {
  font-weight: 900;
  color: #1F2937;
  font-size: 13.5px;
  margin-right: 4px;
  display: inline;
}

/* 4. Results Table (Light Green Header, Large Commanding Text, 100% Width) */
.results-table-wrapper {
  width: 100%;
  margin: 6px 0 8px 0;
}
.results-table {
  width: 100%;
  table-layout: fixed;
  border-collapse: separate;
  border-spacing: 0;
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  overflow: hidden;
}
.results-table th {
  background: #EAF7F0;
  color: #0B6B43;
  padding: 8px 10px;
  font-size: 16.5px;
  font-weight: 900;
  text-align: left;
  border: none;
  border-bottom: 1.5px solid #86C1A4;
  border-right: 1px solid #C4E2D3;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  white-space: nowrap;
}
.results-table th:last-child {
  border-right: none;
}
.results-table td {
  padding: 8px 10px;
  font-size: 16px;
  border: none;
  border-bottom: 1px solid #D1E7DD;
  border-right: 1px solid #D1E7DD;
  vertical-align: middle;
  color: #111827;
  line-height: 1.3;
}
.results-table td:last-child {
  border-right: none;
}
.results-table tbody tr:last-child td {
  border-bottom: none;
}
.results-table tbody tr:nth-child(even) {
  background-color: #F8FDF9;
}

/* 5. End of Report Banner */
.end-report-banner {
  text-align: center;
  font-size: 12px;
  font-weight: 900;
  letter-spacing: 1.8px;
  margin: 6px 0 4px 0;
  color: #0B6B43;
}

/* 6. Signatory & Checked By Section (Fixed Bottom Left & Right) */
.checked-by-wrapper {
  position: fixed;
  bottom: 78px;
  left: 0px;
  width: 240px;
  z-index: 10;
}
.checked-by-box {
  width: 240px;
  text-align: center;
}
.checked-by-space {
  height: 56px;
}
.checked-by-line {
  border-top: 1.5px solid #9CA3AF;
  width: 170px;
  margin: 2px auto 3px auto;
}
.checked-by-name {
  font-weight: 900;
  font-size: 13.5px;
  color: #111827;
}
.checked-by-title {
  font-weight: 800;
  font-size: 11px;
  color: #0B6B43;
  margin-top: 1px;
  text-transform: uppercase;
}

.sig-wrapper {
  position: fixed;
  bottom: 78px;
  right: 0px;
  width: 240px;
  z-index: 10;
}
.sig-box {
  width: 240px;
  text-align: center;
}
.sig-img {
  height: 56px;
  width: auto;
  max-width: 190px;
  object-fit: contain;
  display: block;
  margin: 0 auto 2px auto;
}
.sig-line {
  border-top: 1.5px solid #9CA3AF;
  width: 170px;
  margin: 2px auto 3px auto;
}
.sig-name {
  font-weight: 900;
  font-size: 13.5px;
  color: #111827;
}
.sig-title {
  font-weight: 800;
  font-size: 11px;
  color: #0B6B43;
  margin-top: 1px;
  text-transform: uppercase;
}

/* 6b. Remarks and Notes Box (Open / Borderless) */
.remarks-box {
  margin: 6px 0 6px 0;
  width: 100%;
  border: none;
  page-break-inside: avoid;
}
.notes-box {
  margin: 6px 0 6px 0;
  width: 100%;
  border: none;
  page-break-inside: avoid;
}

/* 7. Static Bottom Pinned Footer with Top/Bottom Line Divider (Left & Right Open) */
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
  border-top: 1.2px solid #000000;
  border-bottom: 1.2px solid #000000;
  border-left: none;
  border-right: none;
  border-radius: 0;
  background: transparent;
  padding: 4px 0;
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

<!-- Watermark Background Logo (Centered with Light Visibility) -->
@if(file_exists($watermarkPath))
<div class="watermark-container">
  <img src="{{ $watermarkPath }}" class="watermark-img" alt="Watermark">
</div>
@endif
@php
  $logoPath = file_exists(public_path('krishi-pdf-logo.png'))
      ? public_path('krishi-pdf-logo.png')
      : (file_exists(public_path('krishi-transparent.png'))
          ? public_path('krishi-transparent.png')
          : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png')));
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;
  
  $checkedByRel = preg_replace('~^storage/~', '', (string)($lab->seal_path ?? ($lab->tested_by_signature_path ?? ($lab->tested_by_path ?? ''))));
  $checkedByPath = $checkedByRel !== '' && file_exists($cbAbs = storage_path('app/public/'.$checkedByRel))
      ? $cbAbs
      : (file_exists(public_path('checked-by.png')) ? public_path('checked-by.png') : (file_exists(public_path('tested-by.png')) ? public_path('tested-by.png') : null));
  
  $customerName = $report->party_name ?: ($report->customer_name ?: ($report->customer?->company_name ?: ($report->customer?->name ?: '—')));
  $matchedCustomer = $report->customer ?: ($report->customer_id ? \App\Models\Customer::find($report->customer_id) : \App\Models\Customer::where('name', $customerName)->orWhere('company_name', $customerName)->first());
  $customerAddress = $report->address ?: ($matchedCustomer?->address ?: ($matchedCustomer?->city ? $matchedCustomer->city . ($matchedCustomer?->pincode ? ' - ' . $matchedCustomer->pincode : '') : ''));
  
  $sampleDateFormatted = $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : ($report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('d-M-Y') : '—');
  $coaDateFormatted = $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : $sampleDateFormatted;
  
  $showSpec = $report->reportType->show_specification ?? true;
  $customCols = $report->reportType->custom_columns ?? [];
  $quantityLabel = $report->reportType?->quantity_label ?: 'Tons / Bags';
  
  $phone = '+91 63793 12357, +91 88838 64756';
  if (!empty($lab->phone)) {
      $phone = str_contains($lab->phone, '88838') ? $lab->phone : $lab->phone . ', +91 88838 64756';
  }
  $email = $lab->email ?: 'krishianalyticallab@gmail.com';
  $website = $lab->website ?: 'www.krishilab25.in';
  $websiteClean = preg_replace('#^https?://#i', '', $website);
  
  $rows = $report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)->values();
@endphp

<!-- 1. Header: Grouped Centered Logo + Vertical Green Line + Company Name & Tagline -->
<div class="header-wrapper">
  <table class="header-group-table" align="center" style="margin: 0 auto; position: relative; left: -25px; border-collapse: collapse;">
    <tr>
      <td style="vertical-align: middle; text-align: center; padding-left: 36px; padding-right: 8px; border: none;">
        @if(file_exists($logoPath))
          <img src="{{ $logoPath }}" class="logo-img" alt="Logo">
        @endif
      </td>
      <td style="vertical-align: middle; text-align: center; padding: 0 8px; width: 4px; border: none;">
        <div class="header-green-bar"></div>
      </td>
      <td style="vertical-align: middle; text-align: center; padding-left: 0; border: none;">
        <div class="company-name">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
        <div class="company-tagline">“{{ $lab->tagline ?? 'Discovering Solutions, One Test at a Time' }}”</div>
      </td>
    </tr>
  </table>
</div>

<!-- 2. Section 1 Badge: TEST REPORT with Smooth Border-Radius Pill -->
<div class="badge-wrapper" style="margin-top: 14px; margin-bottom: 14px;">
  <table class="section-badge-table" align="center">
    <tr>
      <td style="vertical-align: middle;"><div class="badge-line"></div></td>
      <td class="badge-pill-cell">
        <div class="badge-pill">TEST REPORT</div>
      </td>
      <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    </tr>
  </table>
</div>

<!-- 3. Customer & Sample Details Card (Centered Columns & Balanced Margins) -->
<table class="details-outer-box" align="center">
  <tr>
    <td style="padding: 12px 18px; border: none; vertical-align: top;">
      <table class="details-table" align="center">
        <tr>
          <!-- Left Column (50%) -->
          <td style="width: 50%; padding-right: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 114px;">
                <col style="width: auto;">
              </colgroup>
              @if(!empty($customerName) && $customerName !== '—')
              <tr>
                <td class="lbl-col">Customer</td>
                <td class="val-col">
                  <span class="colon-sep">:</span>{{ $customerName }}
                  @if($report->customer?->group?->name)
                    <span style="font-weight: bold; font-size: 11.5px; color: #4B5563;">({{ $report->customer->group->name }})</span>
                  @endif
                </td>
              </tr>
              @endif
              @if(!empty($customerAddress) && $customerAddress !== '—')
              <tr>
                <td class="lbl-col">Address</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $customerAddress }}</td>
              </tr>
              @endif
              @if(!empty($report->nature_of_sample))
              <tr>
                <td class="lbl-col">Nature of Sample</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->nature_of_sample }}</td>
              </tr>
              @elseif(!empty($report->reportType?->name))
              <tr>
                <td class="lbl-col">Nature of Sample</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->reportType->name }}</td>
              </tr>
              @endif
              @if(!empty($report->bill_no))
              <tr>
                <td class="lbl-col">Bill No</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->bill_no }}</td>
              </tr>
              @endif
              @if(!empty($report->vehicle_no))
              <tr>
                <td class="lbl-col">Vehicle No</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->vehicle_no }}</td>
              </tr>
              @endif
            </table>
          </td>
          
          <!-- Right Column (shifted right to balance right edge margin) -->
          <td style="width: 50%; padding-left: 110px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 95px;">
                <col style="width: auto;">
              </colgroup>
              @if(!empty($coaDateFormatted) && $coaDateFormatted !== '—')
              <tr>
                <td class="lbl-col">Report Date</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $coaDateFormatted }}</td>
              </tr>
              @endif
              @if(!empty($report->report_no))
              <tr>
                <td class="lbl-col">Report No</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->report_no }}</td>
              </tr>
              @endif
              @if(!empty($report->bags_tons))
              <tr>
                <td class="lbl-col">{{ $quantityLabel }}</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->bags_tons }}</td>
              </tr>
              @endif
              @if(!empty($report->buyer))
              <tr>
                <td class="lbl-col">Buyer</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->buyer }}</td>
              </tr>
              @endif
              @if(!empty($report->seller))
              <tr>
                <td class="lbl-col">Seller</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->seller }}</td>
              </tr>
              @endif
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- 4. Section 2 Badge: TEST RESULTS with Smooth Border-Radius Pill -->
<div class="badge-wrapper" style="margin-top: 16px; margin-bottom: 14px;">
  <table class="section-badge-table" align="center">
    <tr>
      <td style="vertical-align: middle;"><div class="badge-line"></div></td>
      <td class="badge-pill-cell">
        <div class="badge-pill">TEST RESULTS</div>
      </td>
      <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    </tr>
  </table>
</div>

@php
  $tableCols = $report->reportType?->table_columns;
  if (!is_array($tableCols) || empty($tableCols)) {
    $tableCols = [
      ['key' => 's_no', 'label' => 'S.NO', 'visible' => true, 'type' => 'system'],
    ];
    if ($showSpec) {
      $tableCols[] = ['key' => 'specification', 'label' => 'SPECIFICATION', 'visible' => true, 'type' => 'system'];
    }
    $tableCols[] = ['key' => 'parameter', 'label' => 'PARAMETER', 'visible' => true, 'type' => 'system'];
    foreach ($customCols as $cIdx => $cName) {
      $tableCols[] = ['key' => 'custom_' . $cIdx, 'label' => $cName, 'visible' => true, 'type' => 'custom'];
    }
    $tableCols[] = ['key' => 'result', 'label' => 'RESULT', 'visible' => true, 'type' => 'system'];
  }
  $activeTableCols = array_values(array_filter($tableCols, fn($c) => ($c['visible'] ?? true) !== false));

  $hasSpec = in_array('specification', array_column($activeTableCols, 'key'));
  $customColsList = array_filter($activeTableCols, fn($c) => ($c['type'] ?? '') === 'custom' || str_starts_with($c['key'] ?? '', 'custom_'));
  $customCount = count($customColsList);

  $rawWeights = [];
  foreach ($activeTableCols as $c) {
    $ckey = $c['key'] ?? '';
    if (!empty($c['width'])) {
      $wNum = floatval(preg_replace('/[^0-9.]/', '', (string)$c['width']));
      if ($wNum > 0) {
        $rawWeights[$ckey] = $wNum;
        continue;
      }
    }

    if ($ckey === 's_no') {
      $rawWeights[$ckey] = 8;
    } elseif ($ckey === 'result') {
      $rawWeights[$ckey] = 18;
    } elseif ($ckey === 'specification') {
      $rawWeights[$ckey] = 22;
    } elseif ($ckey === 'parameter') {
      if ($customCount > 0) {
        $rawWeights[$ckey] = 34;
      } elseif (!$hasSpec) {
        $rawWeights[$ckey] = 74;
      } else {
        $rawWeights[$ckey] = 52;
      }
    } else {
      $rawWeights[$ckey] = 18 / max(1, $customCount);
    }
  }

  $totalWeight = array_sum($rawWeights);
  $colPercentWidths = [];
  if ($totalWeight > 0) {
    foreach ($rawWeights as $ckey => $val) {
      $colPercentWidths[$ckey] = round(($val / $totalWeight) * 100, 1) . '%';
    }
  }
@endphp

<!-- 5. Results Table (3x Bigger, 100% Width, Clear & Perfectly Aligned with DB Column Width Priority) -->
<div class="results-table-wrapper">
  <table class="results-table" align="center">
    <colgroup>
      @foreach($activeTableCols as $col)
        @php
          $ckey = $col['key'] ?? '';
          $w = $colPercentWidths[$ckey] ?? 'auto';
        @endphp
        <col style="width: {{ $w }};">
      @endforeach
    </colgroup>
    <thead>
      <tr>
        @foreach($activeTableCols as $col)
          @php
            $ckey = $col['key'] ?? '';
            $clabel = strtoupper($col['label'] ?? '');
            $isSno = ($ckey === 's_no');
            $isSpec = ($ckey === 'specification');
            $isResult = ($ckey === 'result');
            $w = $colPercentWidths[$ckey] ?? 'auto';
            $align = ($isSno || $isSpec || $isResult) ? 'center' : 'left';
          @endphp
          <th style="width: {{ $w }}; text-align: {{ $align }};">
            {{ $clabel }}
          </th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $idx => $res)
      @php
        $param = $res->parameter;
        $spec = $res->specification ?: ($param->specification ?: '-');
        $resultVal = ($res->result !== null && $res->result !== '') ? $res->result : '-';
      @endphp
      <tr>
        @foreach($activeTableCols as $col)
          @php
            $ckey = $col['key'] ?? '';
            $clabel = $col['label'] ?? '';
            $w = $colPercentWidths[$ckey] ?? 'auto';
          @endphp
          @if($ckey === 's_no')
            <td style="width: {{ $w }}; text-align: center; font-size: 15.5px; font-weight: 900; color: #111827;">{{ $idx + 1 }}</td>
          @elseif($ckey === 'specification')
            <td style="width: {{ $w }}; text-align: center; font-size: 15.5px; font-weight: 800; color: #111827;">{{ $spec }}</td>
          @elseif($ckey === 'parameter')
            <td style="width: {{ $w }}; text-align: left; font-size: 16px; font-weight: 900; color: #000000;">{{ $param->name ?? 'Parameter' }}</td>
          @elseif($ckey === 'result')
            <td style="width: {{ $w }}; text-align: center; font-size: 15.5px; font-weight: 800; color: #111827;">
              {{ $resultVal }}
            </td>
          @else
            @php
              $cVal = '';
              if (is_array($res->custom_values)) {
                $cVal = $res->custom_values[$clabel] ?? ($res->custom_values[$ckey] ?? '');
              }
            @endphp
            <td style="width: {{ $w }}; text-align: center; font-size: 15.5px; font-weight: 800; color: #111827;">{{ $cVal !== '' ? $cVal : '-' }}</td>
          @endif
        @endforeach
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@php
  $remarksVisible = in_array('remarks', $report->reportType?->visible_fields ?? []);
  $remarksRaw = trim((string)($report->remarks ?? ''));
  
  if ($remarksRaw !== '') {
      // Convert markdown **bold** to <strong>bold</strong>
      $remarksFormatted = preg_replace('/\*\*(.*?)\*\*/', '<strong style="color: #000000; font-weight: 900;">$1</strong>', e($remarksRaw));
      
      // Auto-highlight key results (2, Pass, Fail) with thick bold font
      $keywords = ['2', 'Pass', 'Fail', 'PASS', 'FAIL'];
      foreach ($keywords as $kw) {
          $remarksFormatted = preg_replace('/\b(' . preg_quote($kw, '/') . ')\b(?=[^<]*>|[^<]*$)/', '<strong style="color: #000000; font-weight: 900;">$1</strong>', $remarksFormatted);
      }
  } else {
      $remarksFormatted = '';
  }

  $notesVisible = in_array('notes', $report->reportType?->visible_fields ?? []);
  $notesRaw = trim((string)($report->notes ?? ''));
  if ($notesRaw === '' && !empty($report->reportType?->default_notes)) {
      $notesRaw = trim((string)$report->reportType->default_notes);
  }
  $notesFormatted = $notesRaw !== '' ? nl2br(e($notesRaw)) : '';
@endphp

@if(!empty($remarksFormatted))
<div class="remarks-box">
  <div style="font-weight: 800; font-size: 12px; color: #111827; margin-bottom: 2px;">Remarks:</div>
  <div style="font-size: 11.5px; color: #1F2937; line-height: 1.45; padding-left: 6px; padding-right: 6px; text-align: justify;">
    {!! $remarksFormatted !!}
  </div>
</div>
@endif

@if(!empty($notesFormatted))
<div class="notes-box">
  <div style="font-weight: 800; font-size: 12px; color: #111827; margin-bottom: 2px;">Notes:</div>
  <div style="font-size: 11.5px; color: #1F2937; line-height: 1.45; padding-left: 6px; padding-right: 6px; text-align: justify;">
    {!! $notesFormatted !!}
  </div>
</div>
@endif

<!-- 6. End of Report Banner -->
<div class="end-report-banner">
  ************* End of the Report *************
</div>

<!-- 7. Signatory & Checked By Section (Left & Right Opposite) -->
<div class="checked-by-wrapper">
  <div class="checked-by-box">
    @if($checkedByPath)
      <img src="{{ $checkedByPath }}" class="sig-img" alt="Checked By Signature">
    @else
      <div class="checked-by-space">&nbsp;</div>
    @endif
    <div class="checked-by-line"></div>
    <div class="checked-by-name">Checked By</div>
  </div>
</div>

<div class="sig-wrapper">
  <div class="sig-box">
    @if($sigPath)
      <img src="{{ $sigPath }}" class="sig-img" alt="Signature">
    @else
      <div style="height: 56px;">&nbsp;</div>
    @endif
    <div class="sig-line"></div>
    <div class="sig-name">Authorized Signatory</div>
    <div class="sig-title">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
  </div>
</div>

<!-- 8. Static Pinned Bottom Footer with Horizontal Box & Outside Note -->
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
    Note: Test results relate only to the items tested. Test Report shall not be reproduced in full or part without the approval of the laboratory.
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

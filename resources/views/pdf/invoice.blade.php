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

/* 3. Customer & Invoice Details Card */
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

/* 4. Items Table */
.items-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 4px;
  border: 1.5px solid #86C1A4;
}
.items-table th {
  background-color: #EAF7F0;
  color: #0B6B43;
  padding: 7px 10px;
  font-size: 14.5px;
  font-weight: 900;
  text-align: left;
  border: 1px solid #86C1A4;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  height: 30px;
}
.items-table td {
  border: 1px solid #D1E7DD;
  padding: 6px 10px;
  height: 26px;
  font-size: 14px;
  font-weight: 700;
  vertical-align: middle;
  color: #111827;
}
.items-table tbody tr:nth-child(even) {
  background-color: #F8FDF9;
}

/* 5. Totals Table */
.totals-table {
  width: 320px;
  border-collapse: collapse;
  margin-left: auto;
  margin-top: 8px;
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  overflow: hidden;
}
.totals-table td {
  border: 1px solid #D1E7DD;
  padding: 6px 10px;
  font-size: 13px;
}
.totals-table .label {
  background-color: #EAF7F0;
  font-weight: 800;
  font-size: 13.5px;
  color: #0B6B43;
}
.totals-table .grand {
  background-color: #ffffff;
  font-weight: 900;
  font-size: 15.5px;
  color: #000000;
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
  $logoPath = file_exists(public_path('krishi-pdf-logo.png'))
      ? public_path('krishi-pdf-logo.png')
      : (file_exists(public_path('krishi-transparent.png'))
          ? public_path('krishi-transparent.png')
          : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png')));
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;
  
  $gstin = $lab->gstin ?? '';
  $fmt = function($v){ $v = round(floatval($v), 2); return (fmod($v, 1) == 0) ? number_format($v, 0) : number_format($v, 2); };
  
  $partyName = $report->party_name ?: ($report->customer_name ?: ($report->customer?->company_name ?: ($report->customer?->name ?: ($invoice->party_name ?: ($invoice->customer_name ?: '—')))));
  $custGroup = $report->customer?->group?->name ?? null;
  $custAddr = $report->customer?->address ?: ($invoice->customer_address ?? '');
  $custGstin = $report->customer?->gstin ?: ($invoice->customer_gstin ?? '');
  $custPhone = $report->customer?->phone ?: ($invoice->customer_phone ?? '');
  
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

<!-- 2. Section 1 Badge: INVOICE -->
<table class="section-badge-table" align="center">
  <tr>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    <td class="badge-pill-cell">
      <div class="badge-pill">INVOICE</div>
    </td>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
  </tr>
</table>

<!-- 3. Customer & Invoice Details Card -->
<table class="details-outer-box" align="center">
  <tr>
    <td style="padding: 12px 18px; border: none; vertical-align: top;">
      <table class="details-table" align="center">
        <tr>
          <!-- Left Column (58%) -->
          <td style="width: 58%; padding-right: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 120px;">
                <col style="width: auto;">
              </colgroup>
              @if(!empty($partyName) && $partyName !== '—')
              <tr>
                <td class="lbl-col">Customer</td>
                <td class="val-col">
                  <span class="colon-sep">:</span>{{ $partyName }}
                  @if($custGroup)
                    <span style="font-weight: bold; font-size: 11.5px; color: #4B5563;">({{ $custGroup }})</span>
                  @endif
                </td>
              </tr>
              @endif
              @if(!empty($custAddr))
              <tr>
                <td class="lbl-col">Address</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $custAddr }}</td>
              </tr>
              @endif
              @if(!empty($custPhone))
              <tr>
                <td class="lbl-col">Contact No</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $custPhone }}</td>
              </tr>
              @endif
              @if(!empty($report->report_no))
              <tr>
                <td class="lbl-col">Report No</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $report->report_no }}</td>
              </tr>
              @endif
            </table>
          </td>
          
          <!-- Right Column (42%) -->
          <td style="width: 42%; padding-left: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 105px;">
                <col style="width: auto;">
              </colgroup>
              <tr>
                <td class="lbl-col">Invoice No</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $invoice->invoice_no }}</td>
              </tr>
              <tr>
                <td class="lbl-col">Invoice Date</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</td>
              </tr>
              @if($invoice->gst_enabled && $gstin)
              <tr>
                <td class="lbl-col">GSTIN</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $gstin }}</td>
              </tr>
              @endif
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- 4. Section 2 Badge: INVOICE PARTICULARS -->
<table class="section-badge-table" align="center">
  <tr>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    <td class="badge-pill-cell">
      <div class="badge-pill">INVOICE PARTICULARS</div>
    </td>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
  </tr>
</table>

<!-- 5. Items Table -->
<table class="items-table">
  <thead>
    <tr>
      <th style="width: 45px; text-align: center;">S.No</th>
      <th>Parameter / Description</th>
      <th style="width: 65px; text-align: center;">Qty</th>
      <th style="width: 110px; text-align: right;">Rate (<span class="rupee">&#8377;</span>)</th>
      <th style="width: 125px; text-align: right;">Amount (<span class="rupee">&#8377;</span>)</th>
    </tr>
  </thead>
  <tbody>
    @php 
      $allInvoiceItems = $invoice->items;
      if ($allInvoiceItems->count() === 0) {
        $invItems = $report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)
          ->map(function($res) {
            return (object)[
              'name' => $res->parameter->name,
              'unit' => $res->parameter->unit,
              'qty' => 1,
              'rate' => floatval($res->parameter->price ?? 0),
              'amount' => floatval($res->parameter->price ?? 0),
            ];
          });
      } else {
        $invItems = $allInvoiceItems->sortBy('display_order');
      }

      // Hide rows where rate is 0 or qty is 0
      $filteredItems = $invItems->filter(function($it) {
        return floatval($it->rate) > 0 && intval($it->qty) > 0;
      })->values();
    @endphp
    @if($filteredItems->count())
      @foreach($filteredItems as $i => $it)
      <tr>
        <td style="text-align: center; font-weight: 900; color: #000000;">{{ $i + 1 }}</td>
        <td>
          <strong style="font-weight: 900; color: #000000;">{{ $it->name }}</strong>
          @if($it->unit && $it->unit !== '%')
            <span style="color: #4B5563; font-weight: normal;">({{ $it->unit }})</span>
          @endif
        </td>
        <td style="text-align: center; font-weight: 900; color: #000000;">{{ intval($it->qty) }}</td>
        <td style="text-align: right; font-weight: 900; color: #000000;">{{ $fmt($it->rate) }}</td>
        <td style="text-align: right; font-weight: 900; color: #000000;">{{ $fmt($it->amount) }}</td>
      </tr>
      @endforeach
    @else
      <tr>
        <td colspan="5" style="text-align: center; color: #6B7280; padding: 10px;">No billable items</td>
      </tr>
    @endif
  </tbody>
</table>

<!-- 6. Totals Table -->
<table class="totals-table">
  <tr>
    <td class="label">Subtotal</td>
    <td style="text-align: right; font-weight: 900; font-size: 14px; color: #000000;"><span class="rupee">&#8377;</span> {{ $fmt($invoice->subtotal) }}</td>
  </tr>
  @if($invoice->gst_enabled)
  <tr>
    <td class="label">GST ({{ rtrim(rtrim(number_format($invoice->gst_percent,2), '0'), '.') }}%)</td>
    <td style="text-align: right; font-weight: 900; font-size: 14px; color: #000000;"><span class="rupee">&#8377;</span> {{ $fmt($invoice->gst_amount) }}</td>
  </tr>
  @endif
  <tr class="grand">
    <td class="label" style="background-color: #EAF7F0; color: #0B6B43; font-size: 14px; font-weight: 900;">Total Amount</td>
    <td style="text-align: right; font-weight: 900; font-size: 15.5px; color: #0B6B43;"><span class="rupee">&#8377;</span> {{ $fmt($invoice->total_amount) }}</td>
  </tr>
</table>

<!-- 7. End of Invoice Banner -->
<div class="end-report-banner">
  ************* End of Invoice *************
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
    Note: This is a computer-generated tax invoice.
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

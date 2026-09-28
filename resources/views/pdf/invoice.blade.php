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

/* Pure Clean Bold Black TAX INVOICE Title */
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

/* Customer & Invoice Details 2-Column Section (Clean Borderless - NO BOX) */
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
  width: 130px;
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

.rupee {
  font-family: 'DejaVu Sans', sans-serif;
  font-weight: normal;
}

/* Pure Clean Bold Black TEST RESULTS Section Title */
.section-title-container {
  text-align: center;
  margin: 10px 0 6px 0;
}
.section-title {
  font-size: 18px;
  font-weight: 900;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: #000000;
  margin: 0;
  line-height: 1.2;
}

/* Items Table */
.items-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 2px;
  border: 1.5px solid #000000;
}
.items-table th {
  background: #ffffff;
  color: #000000;
  padding: 5.5px 6px;
  font-size: 10.5px;
  font-weight: 900;
  text-align: left;
  border: 1px solid #000000;
  text-transform: uppercase;
}
.items-table td {
  border: 1px solid #000000;
  padding: 5px 6px;
  height: 21px;
  font-size: 10.5px;
  vertical-align: middle;
}

/* Totals Table */
.totals-table {
  width: 270px;
  border-collapse: collapse;
  margin-left: auto;
  margin-top: 8px;
  border: 1.5px solid #000000;
}
.totals-table td {
  border: 1px solid #000000;
  padding: 5px 8px;
  font-size: 11px;
}
.totals-table .label {
  background: #F9FAFB;
  font-weight: 700;
}
.totals-table .grand {
  background: #ffffff;
  font-weight: 900;
  font-size: 12px;
}

/* Signatory Section */
.sig-wrapper {
  width: 100%;
  margin-top: 12px;
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
</style>
</head>
<body>
@php
  $logoPath = file_exists(public_path('krishi-transparent.png')) 
      ? public_path('krishi-transparent.png') 
      : (file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png'));
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

<!-- Pure Clean Bold Black INVOICE Title -->
<div class="report-title-container">
  <div class="report-main-title">INVOICE</div>
</div>

<!-- Customer & Invoice Details (Two Columns Key-Value - NO BOX) -->
<table class="details-table" style="width: 100%; margin-bottom: 8px;">
  <tr>
    <!-- Left Column: Customer & Report Details -->
    <td style="width: 58%; padding-right: 10px; vertical-align: top;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col" style="width: 115px;">Customer</td>
          <td class="sep-col">:</td>
          <td class="val-col">
            {{ $partyName }}
            @if($custGroup)
              <span style="font-weight: normal; font-size: 9.5px; color: #4B5563; margin-left: 4px;">(Group: {{ $custGroup }})</span>
            @endif
          </td>
        </tr>
        @if(!empty($custAddr))
        <tr>
          <td class="lbl-col" style="width: 115px;">Address</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $custAddr }}</td>
        </tr>
        @endif
        @if(!empty($custPhone))
        <tr>
          <td class="lbl-col" style="width: 115px;">Contact Number</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $custPhone }}</td>
        </tr>
        @endif
        <tr>
          <td class="lbl-col" style="width: 115px;">Report Number</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $report->report_no }}</td>
        </tr>
      </table>
    </td>

    <!-- Right Column: Invoice Details -->
    <td style="width: 42%; padding-left: 10px; vertical-align: top;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col" style="width: 105px;">Invoice Number</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $invoice->invoice_no }}</td>
        </tr>
        <tr>
          <td class="lbl-col" style="width: 105px;">Invoice Date</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-M-Y') }}</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- Items Table -->
<table class="items-table">
  <thead>
    <tr>
      <th style="width: 36px; text-align: center;">S.No</th>
      <th>Parameter</th>
      <th style="width: 55px; text-align: center;">Qty</th>
      <th style="width: 95px; text-align: right;">Rate (<span class="rupee">&#8377;</span>)</th>
      <th style="width: 110px; text-align: right;">Amount (<span class="rupee">&#8377;</span>)</th>
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

      // Hide rows where rate is 0 or qty is 0 (or both are 0)
      $filteredItems = $invItems->filter(function($it) {
        return floatval($it->rate) > 0 && intval($it->qty) > 0;
      })->values();
    @endphp
    @if($filteredItems->count())
      @foreach($filteredItems as $i => $it)
      <tr>
        <td style="text-align: center;">{{ $i + 1 }}</td>
        <td>
          <strong>{{ $it->name }}</strong>
          @if($it->unit && $it->unit !== '%')
            <span style="color: #4B5563; font-weight: normal;">({{ $it->unit }})</span>
          @endif
        </td>
        <td style="text-align: center;">{{ intval($it->qty) }}</td>
        <td style="text-align: right;">{{ $fmt($it->rate) }}</td>
        <td style="text-align: right; font-weight: bold;">{{ $fmt($it->amount) }}</td>
      </tr>
      @endforeach
    @else
      <tr>
        <td colspan="5" style="text-align: center; color: #6B7280; padding: 8px;">No billable items</td>
      </tr>
    @endif
  </tbody>
</table>

<!-- Totals Table -->
<table class="totals-table">
  <tr>
    <td class="label">Subtotal</td>
    <td style="text-align: right;"><span class="rupee">&#8377;</span> {{ $fmt($invoice->subtotal) }}</td>
  </tr>
  @if($invoice->gst_enabled)
  <tr>
    <td class="label">GST ({{ rtrim(rtrim(number_format($invoice->gst_percent,2), '0'), '.') }}%)</td>
    <td style="text-align: right;"><span class="rupee">&#8377;</span> {{ $fmt($invoice->gst_amount) }}</td>
  </tr>
  @endif
  <tr class="grand">
    <td class="label">Total Amount</td>
    <td style="text-align: right; font-weight: 900; font-size: 12px;"><span class="rupee">&#8377;</span> {{ $fmt($invoice->total_amount) }}</td>
  </tr>
</table>

@if($invoice->gst_enabled && $gstin)
<div style="font-size: 8.5px; color: #4B5563; margin-top: 4px; text-align: right;">
  GSTIN: {{ $gstin }} &nbsp;&bull;&nbsp; Round off as applicable
</div>
@endif

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
        Note: This is a computer-generated tax invoice.
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

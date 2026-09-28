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

/* Pure Clean Bold Black GROUP SUMMARY Title */
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

/* Details 2-Column Section (Clean Borderless) */
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

/* Cards Summary */
.cards { width: 100%; border-collapse: collapse; margin-top: 8px; border: 1.5px solid #000000; }
.cards td { border: 1px solid #000000; padding: 6px 8px; text-align: center; width: 25%; }
.cards .lbl { background: #F9FAFB; font-size: 9.5px; font-weight: 700; text-transform: uppercase; color: #4B5563; }
.cards .val { font-size: 14px; font-weight: bold; color: #0B6B43; }

/* Items Table */
.items { width: 100%; border-collapse: collapse; border: 1.5px solid #000000; margin-top: 10px; }
.items th { background: #ffffff; color: #000000; padding: 5.5px 6px; font-size: 10px; border: 1px solid #000000; text-transform: uppercase; font-weight: 900; }
.items td { border: 1px solid #000000; padding: 4.5px 6px; height: 21px; font-size: 10px; vertical-align: middle; }
.items tr.tot td { background: #F9FAFB; font-weight: bold; }
.badge { font-size: 9.5px; font-weight: 700; }
.paid { color: #168B57; }
.unpaid { color: #DC2626; }
.partial { color: #B45309; }

.grand { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1.5px solid #000000; }
.grand td { border: 1px solid #000000; padding: 6px 8px; font-size: 11px; }
.grand .lbl { background: #F9FAFB; font-weight: 700; }
.grand .val { background: #ffffff; color: #0B6B43; font-weight: 900; font-size: 13px; text-align: right; }

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
  
  $fmt = function($v){ $v = round(floatval($v), 2); return (fmod($v, 1) == 0) ? number_format($v, 0) : number_format($v, 2); };
  $scopeName = $data['scope']==='group'
      ? ($data['group']->name ?? 'Group')
      : ($data['customer']->company_name ?? ($data['customer']->name ?? 'Customer'));
  $title = $data['scope']==='group' ? 'GROUP SUMMARY' : 'CUSTOMER SUMMARY';
  $balance = round($data['totals']['amount'] - $data['totals']['paid_amount'], 2);
  
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

<!-- Pure Clean Bold Black Title -->
<div class="report-title-container">
  <div class="report-main-title">{{ $title }}</div>
</div>

<!-- Group / Customer Details (Two Columns Key-Value - NO BOX) -->
<table class="details-table">
  <tr>
    <!-- Left Column -->
    <td style="width: 55%; padding-right: 8px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col">{{ $data['scope']==='group' ? 'Group Name' : 'Customer Name' }}</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ $scopeName }}</td>
        </tr>
      </table>
    </td>

    <!-- Right Column -->
    <td style="width: 45%; padding-left: 8px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="lbl-col" style="width: 90px;">Period</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y') }} to {{ \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y') }}</td>
        </tr>
        <tr>
          <td class="lbl-col" style="width: 90px;">Generated On</td>
          <td class="sep-col">:</td>
          <td class="val-col">{{ \Carbon\Carbon::now()->format('d-M-Y') }}</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table class="cards">
  <tr>
    <td><div class="lbl">Customers</div><div class="val">{{ count($data['rows']) }}</div></td>
    <td><div class="lbl">Invoices</div><div class="val">{{ $data['totals']['invoices'] }}</div></td>
    <td><div class="lbl">Total Billed</div><div class="val"><span class="rupee">&#8377;</span> {{ $fmt($data['totals']['amount']) }}</div></td>
    <td><div class="lbl">Received</div><div class="val"><span class="rupee">&#8377;</span> {{ $fmt($data['totals']['paid_amount']) }}</div></td>
  </tr>
</table>

<table class="items">
  <thead>
    <tr>
      <th style="width: 32px; text-align: center;">S.No</th>
      <th>Customer</th>
      <th style="width: 58px; text-align: center;">Invoices</th>
      <th style="width: 52px; text-align: center;">Paid</th>
      <th style="width: 52px; text-align: center;">Unpaid</th>
      <th style="width: 52px; text-align: center;">Partial</th>
      <th style="width: 88px; text-align: right;">Amount (<span class="rupee">&#8377;</span>)</th>
      <th style="width: 88px; text-align: right;">Received (<span class="rupee">&#8377;</span>)</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data['rows'] as $i => $row)
    <tr>
      <td style="text-align: center;">{{ $i+1 }}</td>
      <td><strong>{{ $row['party'] }}</strong></td>
      <td style="text-align: center;">{{ $row['invoices'] }}</td>
      <td style="text-align: center;"><span class="badge paid">{{ $row['paid'] }}</span></td>
      <td style="text-align: center;"><span class="badge unpaid">{{ $row['unpaid'] }}</span></td>
      <td style="text-align: center;"><span class="badge partial">{{ $row['partial'] }}</span></td>
      <td style="text-align: right;">{{ $fmt($row['amount']) }}</td>
      <td style="text-align: right;">{{ $fmt($row['paid_amount']) }}</td>
    </tr>
    @endforeach
    <tr class="tot">
      <td colspan="2">TOTAL</td>
      <td style="text-align: center;">{{ $data['totals']['invoices'] }}</td>
      <td colspan="3"></td>
      <td style="text-align: right;">{{ $fmt($data['totals']['amount']) }}</td>
      <td style="text-align: right;">{{ $fmt($data['totals']['paid_amount']) }}</td>
    </tr>
  </tbody>
</table>

<table class="grand">
  <tr>
    <td class="lbl" style="width: 60%;">Outstanding (Billed − Received)</td>
    <td class="val"><span class="rupee">&#8377;</span> {{ $fmt($balance) }}</td>
  </tr>
</table>

<div style="width: 100%; margin-top: 14px; page-break-inside: avoid; clear: both;">
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
        Note: This is a computer-generated summary statement.
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

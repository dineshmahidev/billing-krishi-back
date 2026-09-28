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

/* Pure Clean Bold Black Title */
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

.ref { text-align: center; font-size: 10.5px; color: #000000; margin: 4px 0 10px; }
.ref b { color: #000000; font-size: 11.5px; }

/* Clean Borderless Details Table */
.details-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 12px;
  font-size: 10.5px;
}
.details-table td {
  vertical-align: top;
  border: none;
  padding: 3px 2px;
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

.message-box { 
  border: 1px solid #D1D5DB; 
  background: #F9FAFB; 
  padding: 8px 10px; 
  margin: 10px 0 12px 0; 
}
.message-box .h { font-weight: bold; color: #0B6B43; margin-bottom: 4px; font-size: 11px; }
.message-box .b { color: #111827; font-size: 10.5px; }

.next { border-top: 1px solid #000000; padding-top: 10px; font-size: 10px; color: #374151; }
.next b { color: #0B6B43; }

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
  <div class="report-main-title">{{ $e->typeLabel() }}</div>
</div>
<div class="ref">Reference : <b>{{ $e->ref() }}</b> &nbsp;&bull;&nbsp; Received : {{ $e->created_at?->format('d-M-Y, h:i A') }}</div>

<table class="details-table">
  <tr>
    <td style="width: 50%; padding-right: 8px;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr><td class="lbl-col">Customer</td><td class="sep-col">:</td><td class="val-col">{{ $e->name }}</td></tr>
        <tr><td class="lbl-col">Phone Number</td><td class="sep-col">:</td><td class="val-col">{{ $e->phone }}</td></tr>
        <tr><td class="lbl-col">Email Address</td><td class="sep-col">:</td><td class="val-col">{{ $e->email ?: '—' }}</td></tr>
      </table>
    </td>
    <td style="width: 50%; padding-left: 8px;">
      <table style="width: 100%; border-collapse: collapse;">
        @if($e->sample_type)
        <tr><td class="lbl-col">Sample Type</td><td class="sep-col">:</td><td class="val-col">{{ $e->sample_type }}</td></tr>
        @endif
        <tr><td class="lbl-col">Submitted On</td><td class="sep-col">:</td><td class="val-col">{{ $e->created_at?->format('d-M-Y, h:i A') }}</td></tr>
      </table>
    </td>
  </tr>
</table>

<div class="message-box">
  <div class="h">Message / Requirements</div>
  <div class="b">{{ $e->message ?: '—' }}</div>
</div>

<div class="next">
  <b>Next steps:</b> 1. We call you to confirm requirements &nbsp; 2. Sample collection / lab drop-off &nbsp; 3. Report delivered within promised turnaround with softcopy download.
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
        Note: This is a computer-generated enquiry acknowledgement.
      </td>
    </tr>
  </table>
</div>
</body>
</html>

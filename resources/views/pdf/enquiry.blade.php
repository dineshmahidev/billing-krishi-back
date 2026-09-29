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

.ref-bar {
  text-align: center;
  font-size: 12.5px;
  color: #4B5563;
  margin: 2px 0 8px 0;
  font-weight: 700;
}
.ref-bar b {
  color: #0B6B43;
  font-size: 13.5px;
}

/* 3. Customer & Enquiry Details Card */
.details-outer-box {
  width: 100%;
  border: 1.5px solid #86C1A4;
  border-radius: 6px;
  background-color: #F8FDF9;
  margin: 0 auto 10px auto;
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
  padding: 3px 0;
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

.message-box { 
  border: 1.5px solid #86C1A4; 
  border-radius: 6px;
  background-color: #F8FDF9; 
  padding: 10px 14px; 
  margin: 10px 0 14px 0; 
}
.message-box .h { 
  font-weight: 800; 
  color: #0B6B43; 
  margin-bottom: 4px; 
  font-size: 13.5px; 
  text-transform: uppercase;
}
.message-box .b { 
  color: #1F2937; 
  font-size: 12.5px; 
  line-height: 1.45;
}

.next { 
  border: 1px dashed #86C1A4; 
  border-radius: 6px;
  background: #EAF7F0; 
  padding: 8px 12px; 
  font-size: 11.5px; 
  color: #1F2937; 
}
.next b { 
  color: #0B6B43; 
}

/* 4. End of Document Banner */
.end-report-banner {
  text-align: center;
  font-size: 11px;
  font-weight: 900;
  letter-spacing: 1.8px;
  margin: 10px 0 6px 0;
  color: #0B6B43;
}

/* 5. Static Bottom Pinned Footer with Horizontal Box & Outside Note */
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

<!-- 2. Section 1 Badge: ENQUIRY TITLE -->
<table class="section-badge-table" align="center">
  <tr>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
    <td class="badge-pill-cell">
      <div class="badge-pill">{{ $e->typeLabel() }}</div>
    </td>
    <td style="vertical-align: middle;"><div class="badge-line"></div></td>
  </tr>
</table>

<div class="ref-bar">Reference : <b>{{ $e->ref() }}</b> &nbsp;&bull;&nbsp; Received : {{ $e->created_at?->format('d-M-Y, h:i A') }}</div>

<!-- 3. Customer & Enquiry Details Card -->
<table class="details-outer-box" align="center">
  <tr>
    <td style="padding: 12px 18px; border: none; vertical-align: top;">
      <table class="details-table" align="center">
        <tr>
          <!-- Left Column (50%) -->
          <td style="width: 50%; padding-right: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 120px;">
                <col style="width: auto;">
              </colgroup>
              <tr>
                <td class="lbl-col">Customer</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $e->name }}</td>
              </tr>
              <tr>
                <td class="lbl-col">Phone Number</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $e->phone }}</td>
              </tr>
              @if(!empty($e->email))
              <tr>
                <td class="lbl-col">Email Address</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $e->email }}</td>
              </tr>
              @endif
            </table>
          </td>
          
          <!-- Right Column (50%) -->
          <td style="width: 50%; padding-left: 14px; vertical-align: top;">
            <table class="inner-meta-table">
              <colgroup>
                <col style="width: 110px;">
                <col style="width: auto;">
              </colgroup>
              @if(!empty($e->sample_type))
              <tr>
                <td class="lbl-col">Sample Type</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $e->sample_type }}</td>
              </tr>
              @endif
              <tr>
                <td class="lbl-col">Submitted On</td>
                <td class="val-col"><span class="colon-sep">:</span>{{ $e->created_at?->format('d-M-Y, h:i A') }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div class="message-box">
  <div class="h">Message / Requirements</div>
  <div class="b">{{ $e->message ?: '—' }}</div>
</div>

<div class="next">
  <b>Next steps:</b> 1. We call you to confirm requirements &nbsp;&bull;&nbsp; 2. Sample collection / lab drop-off &nbsp;&bull;&nbsp; 3. Report delivered within promised turnaround with softcopy download.
</div>

<div class="end-report-banner">
  ************* End of Acknowledgement *************
</div>

<!-- 4. Static Pinned Bottom Footer with Horizontal Box & Outside Note -->
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
    Note: This is a computer-generated enquiry acknowledgement.
  </div>
</div>
</body>
</html>

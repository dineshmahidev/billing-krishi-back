<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 168px 14px 96px 14px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 11px; color: #1F2937; line-height: 1.45; margin: 0; background: #FFFFFF; }
.header {
  position: fixed;
  top: -168px;
  left: 0;
  right: 0;
  height: 144px;
  border-bottom: 3px solid #0B6B43;
  padding: 8px 14px;
  text-align: center;
}
.header-group { width: 100%; border-collapse: collapse; text-align: center; }
.header-group td { vertical-align: middle; padding: 0; border: none; }
.logo { height: 128px; width: 128px; object-fit: contain; display: inline-block; }
.brand-block { display: block; width: 100%; text-align: center; }
.brand-name {
  font-weight: bold;
  color: #0B6B43;
  font-size: 36px;
  letter-spacing: 0.5px;
  line-height: 1.1;
  margin: 0;
  text-align: center;
}
.brand-tagline {
  font-size: 14px;
  color: #374151;
  font-weight: bold;
  letter-spacing: 0.6px;
  margin-top: 7px;
  text-align: center;
}
.footer {
  position: fixed;
  bottom: -82px;
  left: 0;
  right: 0;
  height: 80px;
  border-top: 3px solid #168B57;
  text-align: center;
  font-size: 9px;
  color: #6B7280;
  padding-top: 0;
  background: #FFFFFF;
}
.footer-address {
  font-size: 11px;
  font-weight: bold;
  color: #1F2937;
  margin-top: 5px;
  text-align: center;
}
.footer-contact {
  margin: 5px 14px 0;
  background: #EAF7F0;
  border-top: 1.5px solid #A7D7C1;
  border-bottom: 1.5px solid #A7D7C1;
  padding: 4px 8px;
  font-size: 9.5px;
  color: #1F2937;
  font-weight: bold;
}
.footer-contact a { color: #0B6B43; font-weight: bold; text-decoration: none; }
.footer-sep { color: #9CA3AF; margin: 0 10px; }
.divider { border: none; border-top: 2px solid #168B57; margin: 6px 0; }
.title {
  background: #EAF7F0;
  color: #0B6B43;
  display: inline-block;
  padding: 5px 18px;
  font-weight: bold;
  font-size: 13px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin: 10px 0 6px 0;
}
/* BOXES FOR EMPTY SPACE - every cell is a box with border */
.meta-table { width: 100%; border-collapse: collapse; margin: 8px 0 10px 0; font-size: 10.5px; border: 1.5px solid #1F2937; }
.meta-table td { padding: 6px 7px; border: 1px solid #1F2937; height: 22px; vertical-align: middle; font-weight: 700; color: #1F2937; }
.meta-label { background: #EAF7F0; font-weight: bold; width: 130px; }
.section-bar { background: #EAF7F0; border: 1.5px solid #1F2937; border-bottom: none; padding: 6px 10px; font-weight: bold; font-size: 11.5px; letter-spacing: 1.2px; text-transform: uppercase; color: #0B6B43; margin-top: 10px; }
.results-table { width: 100%; border-collapse: collapse; margin-top: 0; border: 1.5px solid #1F2937; }
.results-table th { background: #EAF7F0; color: #0B6B43; padding: 7px 8px; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #1F2937; }
.results-table td { padding: 7px 8px; border: 1px solid #1F2937; font-size: 11px; height: 22px; }
.results-table tr:nth-child(even) td { background: #F9FAFB; border: 1px solid #1F2937; }
.box-empty { display: inline-block; min-width: 100%; min-height: 12px; border: 1px solid #1F2937; }
.remarks { border: 1.5px solid #1F2937; background: #FFFFFF; padding: 0; margin: 12px 0; min-height: 48px; }
.remarks-header { background: #EAF7F0; border-bottom: 1px solid #1F2937; padding: 4px 8px; font-weight: bold; font-size: 9px; text-transform: uppercase; color: #0B6B43; }
.remarks-body { padding: 8px 10px; min-height: 32px; font-size: 10.5px; }
.outer-box { border: 1.5px solid #1F2937; padding: 10px; margin-top: 6px; }
.sig-container {
  width: 100%;
  margin-top: 24px;
  page-break-inside: avoid;
  clear: both;
}
.signature-area {
  float: right;
  width: 200px;
  text-align: center;
  page-break-inside: avoid;
}
.sig-img { height: 64px; width: auto; max-width: 170px; object-fit: contain; display: block; margin: 0 auto 4px auto; }
.sig-line { border-top: 1.5px solid #1F2937; margin-top: 6px; padding-top: 5px; font-weight: bold; font-size: 11px; color: #1F2937; }
.sig-sub { font-size: 9px; color: #6B7280; margin-top: 2px; }
.watermark {
  position: fixed;
  bottom: 130px;
  right: 40px;
  opacity: 0.07;
  z-index: -1;
}
.watermark img { width: 180px; }
.page-number { font-size: 7px; color: #6B7280; }
</style>
</head>
<body>
@php
  $labName = $lab->lab_name ?? 'KRISHI ANALYTICAL LAB';
  $tagline = $lab->tagline ?? 'Discovering Solutions, One Test at a Time';
  $address = $lab->address ?? '182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701, Tiruppur Dist, Tamil Nadu';
  $phone = $lab->phone ?? '+91 63793 12357';
  $email = $lab->email ?? 'info@krishianalyticallab.com';
  $website = $lab->website ?: 'https://krishianalyticallab.com';
  $websiteLabel = preg_replace('#^https?://#i', '', $website);
  $reportTitle = $report->reportType->title ?? (in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed']) ? 'ANALYSIS REPORT' : 'CERTIFICATE OF ANALYSIS');
  // Transparent big logo as requested
  $logoPath = file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;
  $isFeed = in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed','Rice bran','Animal feed']);
@endphp

<div class="header">
  <table class="header-group">
    <tr>
      <td style="width:150px; text-align:left;">
        @if(file_exists($logoPath))
          <img src="{{ $logoPath }}" class="logo" alt="logo">
        @endif
      </td>
      <td class="brand-block">
        <div class="brand-name">{{ $labName }}</div>
        <div class="brand-tagline">"{{ $tagline }}"</div>
      </td>
    </tr>
  </table>
</div>

<div class="footer">
  <div class="footer-address">{{ $address }}</div>
  <div class="footer-contact">
    <span>{{ $phone }}</span><span class="footer-sep">|</span><span>{{ $email }}</span><span class="footer-sep">|</span><a href="{{ $website }}">{{ $websiteLabel }}</a>
  </div>
  <div class="page-number" style="margin-top:4px;">Page <span class="pagenum"></span></div>
</div>

@if(file_exists($logoPath))
<div class="watermark">
  <img src="{{ $logoPath }}" alt="watermark">
</div>
@endif

<div style="text-align:center;">
  <div class="title">{{ $reportTitle }}</div>
</div>
<table style="width:100%; border:none; border-collapse:collapse; font-size:9px; margin-top:4px;">
<tr>
<td style="border:none; padding:0; text-align:left;">Date: <strong>{{ \Carbon\Carbon::parse($report->created_at)->format('d-M-Y') }}</strong></td>
<td style="border:none; padding:0; text-align:right;">Report No: <strong style="border:1px solid #1F2937; padding:2px 6px; font-family:monospace; font-size:11px;">{{ $report->report_no }}</strong></td>
</tr>
</table>

<div class="outer-box">
@php $companyAll = $report->party_name ?? $report->customer_name ?? ''; @endphp
<table class="meta-table">
  <tr><td class="meta-label">Sample Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : '&nbsp;' }}</td><td class="meta-label">COA Date</td><td>{{ $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : '&nbsp;' }}</td></tr>
  <tr><td class="meta-label">Party Name</td><td>{!! $companyAll ? e($companyAll) : '&nbsp;' !!}</td><td class="meta-label">Sample Name</td><td>{!! $report->sample_name ? e($report->sample_name) : '&nbsp;' !!}</td></tr>
  <tr><td class="meta-label">Vehicle No</td><td>{!! $report->vehicle_no ? e($report->vehicle_no) : '&nbsp;' !!}</td><td class="meta-label">Bill No</td><td>{!! $report->bill_no ? e($report->bill_no) : '&nbsp;' !!}</td></tr>
  <tr><td class="meta-label">Bags / Tons</td><td>{!! $report->bags_tons ? e($report->bags_tons) : '&nbsp;' !!}</td><td class="meta-label">Buyer</td><td>{!! $report->buyer ? e($report->buyer) : '&nbsp;' !!}</td></tr>
  <tr><td class="meta-label">Seller</td><td>{!! $report->seller ? e($report->seller) : '&nbsp;' !!}</td><td class="meta-label">Report No</td><td><strong>{{ $report->report_no }}</strong></td></tr>
</table>

@php
  $showSpec = $report->reportType->show_specification ?? true;
  $customCols = $report->reportType->custom_columns ?? [];
  $rows = $report->results->filter(fn($r) => $r->enabled !== false && $r->parameter && $r->parameter->active)->values();
@endphp
<div style="text-align:center;"><div class="title">Test Result</div></div>
<table class="results-table">
  <thead>
    <tr>
      <th style="width: 40px;">S.No</th>
      <th>Parameters</th>
      <th style="width: 110px;">Result</th>
      @if($showSpec)<th>Specification</th>@endif
      @foreach($customCols as $col)<th>{{ $col }}</th>@endforeach
    </tr>
  </thead>
  <tbody>
    @foreach($rows as $idx => $res)
    @php $z = ($idx % 2 === 1) ? 'background:#F9FAFB;' : ''; @endphp
    <tr>
      <td style="text-align:center; height:22px; {{ $z }}">{{ $idx+1 }}</td>
      <td style="{{ $z }}">
        <strong>{{ $res->parameter->name ?? 'Parameter' }}</strong>
        @if($res->parameter->unit && $res->parameter->unit !== '%')<span style="color:#6B7280;"> ({{ $res->parameter->unit }})</span>@endif
      </td>
      <td style="text-align:center; font-weight:700; height:22px; {{ $z }}">{!! ($res->result && $res->result !== '-') ? e($res->result) . (($res->parameter->unit ?? '') === '%' && !str_contains($res->result, '%') ? ' %' : '') : '&nbsp;' !!}</td>
      @if($showSpec)<td style="height:22px; {{ $z }}">{!! ($res->specification ?? $res->parameter->specification) ? e($res->specification ?? $res->parameter->specification) : '&nbsp;' !!}</td>@endif
      @foreach($customCols as $col)<td style="height:22px; {{ $z }}">&nbsp;</td>@endforeach
    </tr>
    @endforeach
  </tbody>
</table>
</div>

<div class="remarks">
  <div class="remarks-header">Remarks / Opinion:</div>
  <div class="remarks-body">{!! $report->remarks ? nl2br(e($report->remarks)) : '&nbsp;<br>&nbsp;' !!}</div>
</div>

<div class="sig-container">
  <div class="signature-area">
    @if($sigPath)
      <img src="{{ $sigPath }}" class="sig-img" alt="signature">
    @else
      <div style="height:52px;">&nbsp;</div>
    @endif
    <div class="sig-line">Authorized Signatory</div>
    <div class="sig-sub">KRISHI ANALYTICAL LAB</div>
  </div>
</div>

<script type="text/php">
  if (isset($pdf)) {
    $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
    $size = 7;
    $font = $fontMetrics->getFont("Helvetica");
    $width = $fontMetrics->get_text_width($text, $font, $size);
    $x = ($pdf->get_width() - $width) / 2;
    $y = $pdf->get_height() - 30;
    $pdf->page_text($x, $y, $text, $font, $size, array(0.42,0.45,0.5));
  }
</script>
</body>
</html>

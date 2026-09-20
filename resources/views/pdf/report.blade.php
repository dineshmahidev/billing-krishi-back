<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 125px 16px 135px 16px;
}
* { font-family: 'Helvetica', 'Arial', sans-serif; }
body { font-size: 11px; color: #1F2937; line-height: 1.45; margin: 0; background: #FFFFFF; }
.header {
  position: fixed;
  top: -115px;
  left: 0;
  right: 0;
  height: 108px;
  text-align: center;
  border-bottom: 2.5px solid #0B6B43;
  padding-bottom: 6px;
  background: #FFFFFF;
}
.footer {
  position: fixed;
  bottom: -62px;
  left: 0;
  right: 0;
  height: 58px;
  border-top: 2.5px solid #168B57;
  text-align: center;
  font-size: 9px;
  color: #6B7280;
  padding-top: 6px;
  background: #FFFFFF;
}
.logo { height: 84px; width: auto; max-width: 100%; object-fit: contain; }
.divider { border: none; border-top: 2px solid #168B57; margin: 6px 0; }
.title {
  background: #0B6B43;
  color: #fff;
  display: inline-block;
  padding: 5px 18px;
  font-weight: 800;
  font-size: 13px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin: 10px 0 6px 0;
}
.meta-table { width: 100%; border-collapse: collapse; margin: 8px 0 10px 0; font-size: 10.5px; }
.meta-table td { padding: 4px 7px; border: 1px solid #D1D5DB; }
.meta-label { font-weight: 700; color: #374151; width: 148px; background: #EAF7F0; font-size: 10px; }
.results-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.results-table th { background: #168B57; color: #fff; padding: 7px 8px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #0B6B43; }
.results-table td { padding: 6px 8px; border: 1px solid #D1D5DB; font-size: 11px; }
.results-table tr:nth-child(even) { background: #F9FAFB; }
.remarks { border: 1px solid #D1D5DB; background: #EAF7F0; padding: 9px 10px; margin: 12px 0; border-radius: 4px; font-size: 10.5px; }
.signature-area {
  position: fixed;
  bottom: 80px;
  right: 16px;
  text-align: right;
  page-break-inside: avoid;
}
.sig-img { height: 96px; width: auto; max-width: 220px; object-fit: contain; }
.watermark {
  position: fixed;
  bottom: 120px;
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
  $reportTitle = $report->reportType->title ?? (in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed']) ? 'ANALYSIS REPORT' : 'CERTIFICATE OF ANALYSIS');
  $logoPath = $lab->logo_path && file_exists(public_path($lab->logo_path)) ? public_path($lab->logo_path) : public_path('logo-krishi.png');
  $sigPath = $lab->signature_path && file_exists(public_path($lab->signature_path)) ? public_path($lab->signature_path) : null;
  $isFeed = in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed','Rice bran','Animal feed']);
@endphp

<div class="header">
  @if(file_exists($logoPath))
    <img src="{{ $logoPath }}" class="logo" alt="logo">
  @else
    <div style="font-weight:900; color:#0B6B43; font-size:14px;">{{ $labName }}</div>
  @endif
  <div style="font-size:7.5px; color:#168B57; font-style:italic;">"{{ $tagline }}"</div>
  <div style="font-size:7px; color:#6B7280; margin-top:2px;">{{ $address }} &bull; Ph: {{ $phone }} &bull; {{ $email }}</div>
</div>

<div class="footer">
  <div>{{ $address }} &bull; Ph: {{ $phone }} &bull; {{ $email }}</div>
  <div class="page-number">Page <span class="pagenum"></span></div>
</div>

@if(file_exists($logoPath))
<div class="watermark">
  <img src="{{ $logoPath }}" alt="watermark">
</div>
@endif

<div style="text-align:center;">
  <div class="title">{{ $reportTitle }}</div>
  <div style="text-align:right; font-size:9px; margin-top:2px;">Report No: <strong style="font-family: monospace; font-size:11px;">{{ $report->report_no }}</strong></div>
</div>

@if($isFeed)
<table class="meta-table">
  <tr><td class="meta-label">Sample Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : '-' }}</td><td class="meta-label">COA Date</td><td>{{ $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : '-' }}</td></tr>
  <tr><td class="meta-label">Party Name</td><td>{{ $report->party_name ?? '-' }}</td><td class="meta-label">Sample Name</td><td>{{ $report->sample_name ?? '-' }}</td></tr>
  <tr><td class="meta-label">Vehicle No</td><td>{{ $report->vehicle_no ?? '-' }}</td><td class="meta-label">Bill No</td><td>{{ $report->bill_no ?? '-' }}</td></tr>
  <tr><td class="meta-label">Bags / Tons</td><td>{{ $report->bags_tons ?? '-' }}</td><td class="meta-label">Buyer</td><td>{{ $report->buyer ?? '-' }}</td></tr>
  <tr><td class="meta-label">Seller</td><td colspan="3">{{ $report->seller ?? '-' }}</td></tr>
</table>
@else
<table class="meta-table">
  <tr><td class="meta-label">Nature of Sample</td><td>{{ $report->nature_of_sample ?? $report->sample_name ?? '-' }}</td><td class="meta-label">Report No</td><td style="font-family:monospace; font-weight:800;">{{ $report->report_no }}</td></tr>
  <tr><td class="meta-label">Customer / Party</td><td>{{ $report->customer_name ?? $report->party_name ?? '-' }}</td><td class="meta-label">Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : \Carbon\Carbon::parse($report->created_at)->format('d-M-Y') }}</td></tr>
  @if($report->sample_name && $report->sample_name !== ($report->nature_of_sample ?? ''))
  <tr><td class="meta-label">Sample Name</td><td colspan="3">{{ $report->sample_name }}</td></tr>
  @endif
</table>
@endif

<table class="results-table">
  <thead>
    <tr>
      <th style="width: 40px;">S.No</th>
      <th>Parameters</th>
      <th style="width: 110px;">Result</th>
      <th>Specification</th>
    </tr>
  </thead>
  <tbody>
    @foreach($report->results as $idx => $res)
    <tr>
      <td style="text-align:center;">{{ $idx+1 }}</td>
      <td>
        <strong>{{ $res->parameter->name ?? 'Parameter' }}</strong>
        @if($res->parameter->unit)<span style="color:#6B7280;"> ({{ $res->parameter->unit }})</span>@endif
      </td>
      <td style="text-align:center; font-weight:700;">{{ $res->result ?? '-' }}</td>
      <td>{{ $res->specification ?? $res->parameter->specification ?? '-' }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@if($report->remarks)
<div class="remarks">
  <strong style="font-size:9px; text-transform:uppercase; color:#0B6B43;">Remarks / Opinion:</strong><br>
  <span style="font-size:9.5px;">{{ $report->remarks }}</span>
</div>
@endif

<div style="height: 110px; page-break-inside: avoid;"></div>
<div class="signature-area">
  @if($sigPath)
    <img src="{{ $sigPath }}" class="sig-img" alt="signature"><br>
  @else
    <div style="height:90px;"></div>
  @endif
  <div style="font-weight:800; font-size:13px; color:#1F2937; border-top:1.5px solid #1F2937; display:inline-block; padding-top:4px; margin-top:6px;">
    Authorized Signatory
  </div>
  <div style="font-size:10px; color:#6B7280; margin-top:2px;">KRISHI ANALYTICAL LAB</div>
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

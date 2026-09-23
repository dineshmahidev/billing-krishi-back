<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 138px 14px 88px 14px;
}
* { font-family: 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 11px; color: #1F2937; line-height: 1.45; margin: 0; background: #FFFFFF; }
.header {
  position: fixed;
  top: -128px;
  left: 0;
  right: 0;
  height: 120px;
  border-bottom: 2.5px solid #0B6B43;
  padding-bottom: 6px;
  background: #FFFFFF;
}
.header-group { width: 100%; border-collapse: collapse; text-align: center; }
.header-group td { vertical-align: middle; padding: 0; border: none; }
.logo { height: 96px; width: 96px; object-fit: contain; display: inline-block; }
.brand-block { display: inline-block; vertical-align: middle; text-align: center; }
.brand-name {
  font-weight: 900;
  color: #0B6B43;
  font-size: 26px;
  letter-spacing: 0.5px;
  line-height: 1.1;
  margin: 0;
  text-align: center;
}
.brand-tagline {
  font-size: 9.5px;
  color: #168B57;
  font-weight: 700;
  letter-spacing: 0.4px;
  margin-top: 4px;
  text-align: center;
}
.footer {
  position: fixed;
  bottom: -74px;
  left: 0;
  right: 0;
  height: 72px;
  border-top: 2.5px solid #168B57;
  text-align: center;
  font-size: 9px;
  color: #6B7280;
  padding-top: 0;
  background: #FFFFFF;
}
.footer-address {
  font-size: 11px;
  font-weight: 700;
  color: #1F2937;
  margin-top: 5px;
  text-align: center;
}
.footer-contact {
  margin: 5px 14px 0;
  background: #DBEAFE;
  border-top: 1.5px solid #168B57;
  border-bottom: 1.5px solid #168B57;
  padding: 4px 8px;
  font-size: 9.5px;
  color: #1F2937;
  font-weight: 700;
}
.footer-sep { color: #168B57; margin: 0 10px; }
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
/* BOXES FOR EMPTY SPACE - every cell is a box with border */
.meta-table { width: 100%; border-collapse: collapse; margin: 8px 0 10px 0; font-size: 10.5px; border: 1.5px solid #1F2937; }
.meta-table td { padding: 6px 7px; border: 1px solid #1F2937; height: 22px; vertical-align: middle; }
.meta-label { font-weight: 700; color: #1F2937; width: 148px; background: #EAF7F0; font-size: 10px; border: 1px solid #1F2937; }
.results-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1.5px solid #1F2937; }
.results-table th { background: #168B57; color: #fff; padding: 7px 8px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #1F2937; }
.results-table td { padding: 7px 8px; border: 1px solid #1F2937; font-size: 11px; height: 22px; }
.results-table tr:nth-child(even) td { background: #F9FAFB; border: 1px solid #1F2937; }
.box-empty { display: inline-block; min-width: 100%; min-height: 12px; border: 1px solid #1F2937; }
.remarks { border: 1.5px solid #1F2937; background: #FFFFFF; padding: 0; margin: 12px 0; min-height: 48px; }
.remarks-header { background: #EAF7F0; border-bottom: 1px solid #1F2937; padding: 4px 8px; font-weight: 800; font-size: 9px; text-transform: uppercase; color: #0B6B43; }
.remarks-body { padding: 8px 10px; min-height: 32px; font-size: 10.5px; }
.outer-box { border: 1.5px solid #1F2937; padding: 10px; margin-top: 6px; }
.signature-area {
  position: fixed;
  bottom: 92px;
  right: 14px;
  text-align: right;
  page-break-inside: avoid;
  border: 1px solid #1F2937;
  padding: 6px 10px;
  background: #FFFFFF;
  min-width: 180px;
  min-height: 78px;
}
.sig-img { height: 72px; width: auto; max-width: 180px; object-fit: contain; }
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
  $reportTitle = $report->reportType->title ?? (in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed']) ? 'ANALYSIS REPORT' : 'CERTIFICATE OF ANALYSIS');
  // Transparent big logo as requested
  $logoPath = file_exists(public_path('krishi-transparent.png')) ? public_path('krishi-transparent.png') : public_path('logo-krishi.png');
  $sigPath = $lab->signature_path && file_exists(public_path($lab->signature_path)) ? public_path($lab->signature_path) : null;
  $isFeed = in_array($report->reportType->name ?? '', ['Rice Bran','Animal Feed','Rice bran','Animal feed']);
@endphp

<div class="header">
  <div style="text-align:center;">
    @if(file_exists($logoPath))
      <img src="{{ $logoPath }}" class="logo" alt="logo">
    @endif
    <div class="brand-block" style="margin-left:10px; vertical-align:middle;">
      <div class="brand-name">{{ $labName }}</div>
      <div class="brand-tagline">"{{ $tagline }}"</div>
    </div>
  </div>
</div>

<div class="footer">
  <div class="footer-address">{{ $address }}</div>
  <div class="footer-contact">
    <span>{{ $email }}</span><span class="footer-sep">|</span><span>{{ $phone }}</span><span class="footer-sep">|</span><span>+91 94433 12345</span>
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
  <div style="text-align:right; font-size:9px; margin-top:2px;">Report No: <strong style="font-family: monospace; font-size:11px; border:1px solid #1F2937; padding:2px 6px; display:inline-block; min-width:90px; text-align:center;">{{ $report->report_no }}</strong></div>
</div>

<div class="outer-box">
@php $companyAll = $report->party_name ?? $report->customer_name ?? ''; @endphp
<table class="meta-table">
  <tr><td class="meta-label">Sample Date</td><td>{{ $report->sample_date ? \Carbon\Carbon::parse($report->sample_date)->format('d-M-Y') : '&nbsp;' }}</td><td class="meta-label">COA Date</td><td>{{ $report->coa_date ? \Carbon\Carbon::parse($report->coa_date)->format('d-M-Y') : '&nbsp;' }}</td></tr>
  <tr><td class="meta-label">Party Name</td><td>{!! $companyAll ? e($companyAll) : '&nbsp;' !!}</td><td class="meta-label">Sample Name</td><td>{!! $report->sample_name ? e($report->sample_name) : '&nbsp;' !!}</td></tr>
  <tr><td class="meta-label">Vehicle No</td><td>{!! $report->vehicle_no ? e($report->vehicle_no) : '&nbsp;' !!}</td><td class="meta-label">Bill No</td><td>{!! $report->bill_no ? e($report->bill_no) : '&nbsp;' !!}</td></tr>
  <tr><td class="meta-label">Bags / Tons</td><td>{!! $report->bags_tons ? e($report->bags_tons) : '&nbsp;' !!}</td><td class="meta-label">Buyer</td><td>{!! $report->buyer ? e($report->buyer) : '&nbsp;' !!}</td></tr>
  <tr><td class="meta-label">Seller</td><td colspan="3">{!! $report->seller ? e($report->seller) : '&nbsp;' !!}</td></tr>
</table>

@php $showSpec = $report->reportType->show_specification ?? true; $customCols = $report->reportType->custom_columns ?? []; @endphp
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
    @foreach($report->results as $idx => $res)
    <tr>
      <td style="text-align:center; height:22px;">{{ $idx+1 }}</td>
      <td>
        <strong>{{ $res->parameter->name ?? 'Parameter' }}</strong>
        @if($res->parameter->unit)<span style="color:#6B7280;"> ({{ $res->parameter->unit }})</span>@endif
      </td>
      <td style="text-align:center; font-weight:700; height:22px;">{!! ($res->result && $res->result !== '-') ? e($res->result) . (($res->parameter->unit ?? '') === '%' && !str_contains($res->result, '%') ? ' %' : '') : '&nbsp;' !!}</td>
      @if($showSpec)<td style="height:22px;">{!! ($res->specification ?? $res->parameter->specification) ? e($res->specification ?? $res->parameter->specification) : '&nbsp;' !!}</td>@endif
      @foreach($customCols as $col)<td style="height:22px;">&nbsp;</td>@endforeach
    </tr>
    @endforeach
    {{-- Fill empty rows to keep box height if less than 8 rows --}}
    @for($i = count($report->results); $i < 8; $i++)
    <tr><td style="height:22px; text-align:center;">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>@if($showSpec)<td>&nbsp;</td>@endif @foreach($customCols as $col)<td>&nbsp;</td>@endforeach</tr>
    @endfor
  </tbody>
</table>
</div>

<div class="remarks">
  <div class="remarks-header">Remarks / Opinion:</div>
  <div class="remarks-body">{!! $report->remarks ? nl2br(e($report->remarks)) : '&nbsp;<br>&nbsp;' !!}</div>
</div>

<div style="height: 40px;"></div>
<div class="signature-area">
  @if($sigPath)
    <img src="{{ $sigPath }}" class="sig-img" alt="signature"><br>
  @else
    <div style="height:56px; border-bottom:1px solid #1F2937; margin-bottom:4px;">&nbsp;</div>
  @endif
  <div style="font-weight:800; font-size:11px; color:#1F2937; text-align:center;">
    Authorized Signatory
  </div>
  <div style="font-size:9px; color:#6B7280; text-align:center;">KRISHI ANALYTICAL LAB</div>
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

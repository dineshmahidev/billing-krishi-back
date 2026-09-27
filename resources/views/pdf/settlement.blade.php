<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
@page {
  size: A4 portrait;
  margin: 136px 26px 74px 26px;
}
* { font-family: 'Krishi', 'Helvetica', 'Arial', sans-serif; box-sizing: border-box; }
body { font-size: 10.5px; color: #1F2937; line-height: 1.38; margin: 0; background: transparent; }

.bg-letterhead {
  position: fixed;
  top: -136px;
  left: -26px;
  width: 210mm;
  height: 297mm;
  z-index: -1000;
}

.title {
  background: #EAF7F0;
  color: #0B6B43;
  display: inline-block;
  padding: 4px 16px;
  font-weight: bold;
  font-size: 12px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  margin: 2px 0 4px 0;
}

.meta-table { width: 100%; border-collapse: collapse; margin: 2px 0 6px 0; font-size: 10px; border: 1.5px solid #1F2937; }
.meta-table td { padding: 4.5px 6px; border: 1px solid #1F2937; vertical-align: top; font-weight: 700; color: #1F2937; height: 20px; }
.meta-label { background: #EAF7F0; font-weight: bold; width: 105px; }

.stmt-table { width: 100%; border-collapse: collapse; margin-top: 2px; }
.stmt-table th { border-bottom: 1.5px solid #1F2937; padding: 4px 6px; font-size: 9.5px; font-weight: bold; text-align: left; background: #EAF7F0; }
.stmt-table td { padding: 3px 5px; font-size: 9.5px; vertical-align: top; border: none; }
.stmt-table tr:nth-child(even) td { background: #F9FAFB; }
.stmt-table .sno { width: 24px; text-align: left; }
.stmt-table .desc { text-align: left; }
.stmt-table .debit { width: 80px; text-align: right; }
.stmt-table .credit { width: 80px; text-align: right; }

.totals-section { width: 100%; border-top: 1.5px solid #1F2937; margin-top: 4px; padding-top: 3px; }
.totals-table { width: 100%; border-collapse: collapse; }
.totals-table td { padding: 2px 5px; font-size: 9.5px; font-weight: bold; border: none; }
.totals-table .lbl { text-align: left; padding-left: 24px; }
.totals-table .val-d { width: 80px; text-align: right; }
.totals-table .val-c { width: 80px; text-align: right; }

.bottom-container { width: 100%; margin-top: 14px; page-break-inside: avoid; clear: both; }
.bottom-table { width: 100%; border-collapse: collapse; }
.bottom-table td { vertical-align: bottom; border: none; padding: 0; }

.bal-box { border: 1.5px solid #D946EF; background: #fff; display: inline-block; }
.bal-lbl { border-right: 1.5px solid #D946EF; padding: 3px 6px; font-size: 10px; font-weight: bold; color: #C026D3; }
.bal-val { padding: 3px 8px; font-size: 10px; font-weight: bold; color: #C026D3; }

.sig-block { text-align: center; width: 180px; margin-left: auto; }
.sig-for { color: #0B6B43; font-weight: bold; font-size: 9.5px; margin-bottom: 3px; }
.sig-img { height: 42px; width: auto; max-width: 150px; object-fit: contain; display: block; margin: 0 auto 2px auto; }
.sig-signer { font-weight: bold; font-size: 9.5px; color: #111827; }
.sig-sub { font-size: 8px; color: #4B5563; }
</style>
</head>
<body>
@php
  $letterheadPath = public_path('letterhead.png');
  $hasLetterhead = file_exists($letterheadPath);
  $fmt = function($v){ $v = round(floatval($v), 2); return number_format($v, 2); };
  $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? ''));
  $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null;

  $custName = $data['customer_name'] ?? 'Party';
  $custAddr = $data['customer_address'] ?? '';
  $fromFormatted = \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y');
  $toFormatted = \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y');
@endphp

@if($hasLetterhead)
  <div class="bg-letterhead">
    <img src="{{ $letterheadPath }}" style="width: 210mm; height: 297mm; display: block;" alt="letterhead">
  </div>
@endif

<div style="text-align:center;">
  <div class="title">CUSTOMER - ACCOUNT STATEMENT</div>
</div>

<table class="meta-table">
  <tr>
    <td class="meta-label">Customer / Party</td>
    <td>
      <div><strong>{{ $custName }}</strong></div>
      @if($custAddr)<div style="font-size:9px; color:#4B5563; margin-top:1px; font-weight:normal;">{!! nl2br(e($custAddr)) !!}</div>@endif
    </td>
    <td class="meta-label">Duration</td>
    <td style="width:130px;"><strong>{{ $fromFormatted }} to {{ $toFormatted }}</strong></td>
  </tr>
  @if(!empty($data['filter_types_label']))
  <tr>
    <td class="meta-label">Report Type</td>
    <td colspan="3"><span style="color:#0B6B43; font-weight:bold;">{{ $data['filter_types_label'] }}</span></td>
  </tr>
  @endif
</table>

<table class="stmt-table">
  <thead>
    <tr>
      <th class="sno">S.No</th>
      <th class="desc">Date &amp; Test Parameters / Description</th>
      <th class="debit">Debit (₹)</th>
      <th class="credit">Credit (₹)</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data['statement_rows'] as $row)
      <tr>
        <td class="sno">{{ $row['sno'] }}.</td>
        <td class="desc">
          @if($row['type'] === 'ob')
            <strong>O/B (Opening Balance)</strong>
          @else
            <span style="font-weight:bold; color:#0B6B43; margin-right:4px;">{{ $row['date'] }}</span>
            @if(!empty($row['company_name']))
              <strong style="color:#111827; font-size:9.5px; margin-right:4px;">[{{ $row['company_name'] }}]</strong>
            @endif
            <span>{{ $row['params_text'] }}</span>
            @if(!empty($row['vehicle_no']))
              <span style="color:#6B7280; font-size:8.5px;">({{ $row['vehicle_no'] }})</span>
            @endif
          @endif
        </td>
        <td class="debit">{{ $fmt($row['debit']) }}</td>
        <td class="credit">{{ $fmt($row['credit']) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="totals-section">
  <table class="totals-table">
    <tr>
      <td class="lbl">Net Total</td>
      <td class="val-d">{{ $fmt($data['totals']['total_debit']) }}</td>
      <td class="val-c">{{ $fmt($data['totals']['total_credit']) }}</td>
    </tr>
    <tr>
      <td class="lbl">Balance Outstanding</td>
      <td class="val-d" style="color:#0B6B43; font-size:10.5px;">₹ {{ $fmt($data['totals']['balance']) }}</td>
      <td class="val-c"></td>
    </tr>
  </table>
</div>

<div class="bottom-container">
  <table class="bottom-table">
    <tr>
      <td style="width:55%;">
        <div class="bal-box">
          <span class="bal-lbl">Balance Rs</span><span class="bal-val">₹ {{ $fmt($data['totals']['balance']) }}/-</span>
        </div>
      </td>
      <td style="width:45%; text-align:right;">
        <div class="sig-block">
          <div class="sig-for">For KRISHI ANALYTICAL LAB</div>
          @if($sigPath)
            <img src="{{ $sigPath }}" class="sig-img" alt="signature">
          @else
            <div style="height:42px;">&nbsp;</div>
          @endif
          <div class="sig-signer">Authorized Signatory</div>
          <div class="sig-sub">(Authorised Signatory)</div>
        </div>
      </td>
    </tr>
  </table>
</div>

<script type="text/php">
  if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
      if ($pageCount > 1) {
        $text = "Page " . $pageNumber . " of " . $pageCount;
        $size = 7.5;
        $font = $fontMetrics->getFont("Helvetica");
        $width = $fontMetrics->getTextWidth($text, $font, $size);
        $x = ($canvas->get_width() - $width) / 2;
        $y = $canvas->get_height() - 14;
        $canvas->text($x, $y, $text, $font, $size, array(0.42, 0.45, 0.5));
      }
    });
  }
</script>
</body>
</html>

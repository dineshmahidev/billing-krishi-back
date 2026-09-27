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
.head-row { text-align: center; }

.meta { width: 100%; border-collapse: collapse; font-size: 10px; border: 1.5px solid #1F2937; margin-top: 4px; }
.meta td { border: 1px solid #1F2937; padding: 4.5px 6px; height: 20px; font-weight: 700; color: #1F2937; }
.meta-label { background: #EAF7F0; font-weight: 700; width: 120px; }

.items { width: 100%; border-collapse: collapse; border: 1.5px solid #1F2937; margin-top: 10px; }
.items th { background: #EAF7F0; color: #1F2937; padding: 5px; font-size: 9px; border: 1px solid #1F2937; text-transform: uppercase; font-weight: bold; }
.items td { border: 1px solid #1F2937; padding: 4px 5px; height: 20px; font-size: 9.5px; }
.items tr.tot td { background: #EAF7F0; font-weight: bold; }
.badge { font-size: 9px; font-weight: 700; }
.paid { color: #168B57; }
.unpaid { color: #DC2626; }
.partial { color: #B45309; }

.cards { width: 100%; border-collapse: collapse; margin-top: 10px; }
.cards td { border: 1.5px solid #1F2937; padding: 6px 8px; text-align: center; width: 25%; }
.cards .lbl { background: #EAF7F0; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #4B5563; }
.cards .val { font-size: 13px; font-weight: bold; color: #0B6B43; }

.grand { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1.5px solid #1F2937; }
.grand td { border: 1px solid #1F2937; padding: 6px 8px; font-size: 11px; }
.grand .lbl { background: #F3F4F6; font-weight: 700; }
.grand .val { background: #EAF7F0; color: #0B6B43; font-weight: bold; font-size: 12.5px; text-align: right; }

.sig-container { width: 100%; margin-top: 16px; page-break-inside: avoid; clear: both; }
.signature-area { float: right; width: 180px; text-align: center; page-break-inside: avoid; }
.sig-img { height: 44px; width: auto; max-width: 150px; object-fit: contain; display: block; margin: 0 auto 3px auto; }
.sig-line { border-top: 1.5px solid #1F2937; margin-top: 4px; padding-top: 3px; font-weight: bold; font-size: 10px; color: #1F2937; }
.sig-sub { font-size: 8.5px; color: #6B7280; margin-top: 1px; }
</style>
</head>
<body>
@php
  $letterheadPath = file_exists(public_path('letterhead.png')) ? public_path('letterhead.png') : null;
  $fmt = function($v){ $v = round(floatval($v), 2); return (fmod($v, 1) == 0) ? number_format($v, 0) : number_format($v, 2); };
  $scopeName = $data['scope']==='group'
      ? ($data['group']->name ?? 'Group')
      : ($data['customer']->company_name ?? ($data['customer']->name ?? 'Party'));
  $title = $data['scope']==='group' ? 'GROUP SUMMARY' : 'PARTY SUMMARY';
  $balance = round($data['totals']['amount'] - $data['totals']['paid_amount'], 2);
@endphp

@if($letterheadPath)
<div class="bg-letterhead">
  <img src="{{ $letterheadPath }}" style="width: 210mm; height: 297mm; display: block;" alt="letterhead" />
</div>
@endif

<div class="head-row">
  <div class="title">{{ $title }}</div>
  <div style="font-size: 8.5px; color: #6B7280;">Generated: {{ now()->format('d-M-Y H:i') }}</div>
</div>

<table class="meta">
  <tr>
    <td class="meta-label">{{ $data['scope']==='group' ? 'Group' : 'Party' }}</td>
    <td><strong>{{ $scopeName }}</strong></td>
    <td class="meta-label">Duration</td>
    <td><strong>{{ \Carbon\Carbon::parse($data['range']['from'])->format('d-M-Y') }} to {{ \Carbon\Carbon::parse($data['range']['to'])->format('d-M-Y') }}</strong></td>
  </tr>
</table>

<table class="cards">
  <tr>
    <td><div class="lbl">Parties</div><div class="val">{{ count($data['rows']) }}</div></td>
    <td><div class="lbl">Invoices</div><div class="val">{{ $data['totals']['invoices'] }}</div></td>
    <td><div class="lbl">Total Billed</div><div class="val">₹ {{ $fmt($data['totals']['amount']) }}</div></td>
    <td><div class="lbl">Received</div><div class="val">₹ {{ $fmt($data['totals']['paid_amount']) }}</div></td>
  </tr>
</table>

<table class="items">
  <tr>
    <th style="width:30px;">S.No</th>
    <th>Party</th>
    <th style="width:55px;">Invoices</th>
    <th style="width:50px;">Paid</th>
    <th style="width:50px;">Unpaid</th>
    <th style="width:50px;">Partial</th>
    <th style="width:85px;">Amount (₹)</th>
    <th style="width:85px;">Received (₹)</th>
  </tr>
  @foreach($data['rows'] as $i => $row)
  <tr>
    <td style="text-align:center;">{{ $i+1 }}</td>
    <td><strong>{{ $row['party'] }}</strong></td>
    <td style="text-align:center;">{{ $row['invoices'] }}</td>
    <td style="text-align:center;"><span class="badge paid">{{ $row['paid'] }}</span></td>
    <td style="text-align:center;"><span class="badge unpaid">{{ $row['unpaid'] }}</span></td>
    <td style="text-align:center;"><span class="badge partial">{{ $row['partial'] }}</span></td>
    <td style="text-align:right;">{{ $fmt($row['amount']) }}</td>
    <td style="text-align:right;">{{ $fmt($row['paid_amount']) }}</td>
  </tr>
  @endforeach
  <tr class="tot">
    <td colspan="2">TOTAL</td>
    <td style="text-align:center;">{{ $data['totals']['invoices'] }}</td>
    <td colspan="3"></td>
    <td style="text-align:right;">{{ $fmt($data['totals']['amount']) }}</td>
    <td style="text-align:right;">{{ $fmt($data['totals']['paid_amount']) }}</td>
  </tr>
</table>

<table class="grand">
  <tr>
    <td class="lbl" style="width:60%;">Outstanding (Billed − Received)</td>
    <td class="val">₹ {{ $fmt($balance) }}</td>
  </tr>
</table>

<div class="sig-container">
  <div class="signature-area">
    @php $sigRel = preg_replace('~^storage/~', '', (string)($lab->signature_path ?? '')); $sigPath = $sigRel !== '' && file_exists($sigAbs = storage_path('app/public/'.$sigRel)) ? $sigAbs : null; @endphp
    @if($sigPath)<img src="{{ $sigPath }}" class="sig-img" alt="signature">@else<div style="height:36px;">&nbsp;</div>@endif
    <div class="sig-line">Authorized Signatory</div>
    <div class="sig-sub">KRISHI ANALYTICAL LAB</div>
  </div>
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
        $y = $canvas->get_height() - 18;
        $canvas->text($x, $y, $text, $font, $size, array(0.42, 0.45, 0.5));
      }
    });
  }
</script>
</body>
</html>

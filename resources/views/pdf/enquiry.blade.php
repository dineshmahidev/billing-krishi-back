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

.title { text-align: center; margin: 0 0 4px; }
.title .pill { display: inline-block; background: #EAF7F0; color: #0B6B43; border: 1.5px solid #168B57; font-weight: bold; font-size: 14px; letter-spacing: 2px; padding: 6px 24px; border-radius: 4px; text-transform: uppercase; }
.ref { text-align: center; font-size: 10.5px; color: #6B7280; margin: 4px 0 12px; }
.ref b { color: #1F2937; font-size: 12px; }

table.details { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
table.details td { border: 1px solid #D1D5DB; padding: 6px 8px; font-size: 10.5px; }
table.details td.lbl { background: #EAF7F0; color: #0B6B43; font-weight: bold; width: 130px; }
table.details tr:nth-child(even) td.val { background: #F9FAFB; }

.message-box { border: 1.5px solid #168B57; background: #F9FAFB; border-radius: 4px; padding: 8px 10px; margin-bottom: 12px; }
.message-box .h { font-weight: bold; color: #0B6B43; margin-bottom: 4px; font-size: 11px; }
.message-box .b { color: #374151; font-size: 10.5px; }

.next { border-top: 1.5px solid #D1D5DB; padding-top: 8px; font-size: 9.5px; color: #374151; }
.next b { color: #0B6B43; }
</style>
</head>
<body>
@php
  $letterheadPath = file_exists(public_path('letterhead.png')) ? public_path('letterhead.png') : null;
@endphp

@if($letterheadPath)
<div class="bg-letterhead">
  <img src="{{ $letterheadPath }}" style="width: 210mm; height: 297mm; display: block;" alt="letterhead" />
</div>
@endif

<div class="title"><span class="pill">{{ $e->typeLabel() }}</span></div>
<div class="ref">Reference: <b>{{ $e->ref() }}</b> &nbsp;&bull;&nbsp; Received: {{ $e->created_at?->format('d M Y, h:i A') }}</div>

<table class="details">
  <tr><td class="lbl">Name</td><td class="val">{{ $e->name }}</td></tr>
  <tr><td class="lbl">Phone</td><td class="val">{{ $e->phone }}</td></tr>
  <tr><td class="lbl">Email</td><td class="val">{{ $e->email ?: '—' }}</td></tr>
  @if($e->sample_type)
  <tr><td class="lbl">Sample Type</td><td class="val">{{ $e->sample_type }}</td></tr>
  @endif
  <tr><td class="lbl">Submitted On</td><td class="val">{{ $e->created_at?->format('d M Y, h:i A') }}</td></tr>
</table>

<div class="message-box">
  <div class="h">Message</div>
  <div class="b">{{ $e->message ?: '—' }}</div>
</div>

<div class="next">
  <b>Next steps:</b> 1. We call you to confirm requirements &nbsp; 2. Sample collection / lab drop-off &nbsp; 3. Report delivered within promised turnaround with softcopy download.
</div>
</body>
</html>

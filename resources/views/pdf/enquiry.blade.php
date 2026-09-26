<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
@php
  $addr = $lab->address ?? '';
  $email = $lab->email ?? '';
  $phone = $lab->phone ?? '';
  $logo = file_exists(public_path('krishi-logo.png')) ? public_path('krishi-logo.png') : public_path('logo-krishi.png');
@endphp
<style>
  * { box-sizing: border-box; }
  body { font-family: Krishi, DejaVu Sans, sans-serif; font-size: 11px; color: #1F2937; margin: 0; }
  @page { size: A4; margin: 110px 14mm 60px 14mm; }

  .header { position: fixed; top: -110px; left: 0; right: 0; height: 96px; background: #fff; border-bottom: 3px solid #0B6B43; padding: 8px 14px; }
  .header table { width: 100%; border-collapse: collapse; }
  .header td { vertical-align: middle; }
  .logo { height: 76px; width: 76px; object-fit: contain; }
  .brand-name { font-size: 30px; font-weight: bold; color: #0B6B43; text-align: center; letter-spacing: 1px; }
  .brand-tagline { font-size: 12px; color: #374151; text-align: center; margin-top: 2px; }

  .title { text-align: center; margin: 0 0 4px; }
  .title .pill { display: inline-block; background: #EAF7F0; color: #0B6B43; border: 1.5px solid #168B57; font-weight: bold; font-size: 15px; letter-spacing: 2px; padding: 7px 26px; border-radius: 4px; text-transform: uppercase; }
  .ref { text-align: center; font-size: 11px; color: #6B7280; margin: 6px 0 16px; }
  .ref b { color: #1F2937; font-size: 13px; }

  table.details { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
  table.details td { border: 1px solid #D1D5DB; padding: 8px 10px; font-size: 11.5px; }
  table.details td.lbl { background: #EAF7F0; color: #0B6B43; font-weight: bold; width: 145px; }
  table.details tr:nth-child(even) td.val { background: #F9FAFB; }

  .message-box { border: 1.5px solid #168B57; background: #F9FAFB; border-radius: 6px; padding: 10px 12px; margin-bottom: 14px; }
  .message-box .h { font-weight: bold; color: #0B6B43; margin-bottom: 5px; font-size: 11.5px; }
  .message-box .b { color: #374151; font-size: 11.5px; }

  .next { border-top: 1.5px solid #D1D5DB; padding-top: 10px; font-size: 10.5px; color: #374151; }
  .next b { color: #0B6B43; }

  .footer { position: fixed; bottom: -60px; left: 0; right: 0; height: 60px; border-top: 2.5px solid #168B57; }
  .footer-address { text-align: center; font-size: 9.5px; color: #374151; padding-top: 7px; font-weight: bold; }
  .footer-contact { text-align: center; font-size: 9px; color: #6B7280; margin-top: 3px; }
</style>

<div class="header">
  <table>
    <tr>
      <td width="100"><img src="{{ $logo }}" class="logo" alt="logo"></td>
      <td>
        <div class="brand-name">{{ $lab->lab_name ?? 'KRISHI ANALYTICAL LAB' }}</div>
        <div class="brand-tagline">{{ $lab->tagline ?? '' }}</div>
      </td>
    </tr>
  </table>
</div>

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

<div class="footer">
  <div class="footer-address">{{ $addr }}</div>
  <div class="footer-contact">{{ $email }} &nbsp;|&nbsp; {{ $phone }}</div>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="margin:0; padding:0; background:#F3F4F6; font-family:Helvetica,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#F3F4F6; padding:24px 12px;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#FFFFFF; border-radius:16px; overflow:hidden; border:1px solid #E5E7EB;">
        <tr>
          <td style="background:linear-gradient(135deg,#0B6B43,#168B57); padding:28px; color:#FFFFFF; text-align:center;">
            <div style="font-size:24px; font-weight:800; letter-spacing:0.5px;">KRISHI ANALYTICAL LAB</div>
            <div style="font-size:12px; opacity:0.9; margin-top:4px;">{{ $lab->tagline ?? '' }}</div>
          </td>
        </tr>
        <tr><td style="padding:28px;">
          <h1 style="margin:0 0 4px; font-size:19px; color:#0B6B43;">Thank you, {{ $enquiry->name }}!</h1>
          <p style="margin:0 0 16px; font-size:14px; color:#374151;">
            We have received your <strong>{{ $enquiry->typeLabel() }}</strong>. Our team will call you back within 30 minutes during lab hours.
          </p>

          <table width="100%" cellpadding="0" cellspacing="0" style="background:#EAF7F0; border:1px solid #D1EEE0; border-radius:12px; font-size:13px; margin-bottom:18px;">
            <tr>
              <td style="padding:12px 16px; color:#6B7280;">Reference No</td>
              <td style="padding:12px 16px; text-align:right; font-weight:800; color:#0B6B43;">{{ $enquiry->ref() }}</td>
            </tr>
            @if($enquiry->sample_type)
            <tr style="border-top:1px solid #D1EEE0;">
              <td style="padding:12px 16px; color:#6B7280;">Sample Type</td>
              <td style="padding:12px 16px; text-align:right; font-weight:700; color:#1F2937;">{{ $enquiry->sample_type }}</td>
            </tr>
            @endif
            <tr style="border-top:1px solid #D1EEE0;">
              <td style="padding:12px 16px; color:#6B7280;">Submitted</td>
              <td style="padding:12px 16px; text-align:right; font-weight:700; color:#1F2937;">{{ $enquiry->created_at?->format('d M Y, h:i A') }}</td>
            </tr>
          </table>

          <p style="margin:0 0 10px; font-size:13px; color:#374151;"><strong>What happens next?</strong></p>
          <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px; color:#374151;">
            <tr><td style="padding:4px 0;">1. We call you to confirm sample &amp; testing requirements.</td></tr>
            <tr><td style="padding:4px 0;">2. You drop the sample at our lab or request pickup.</td></tr>
            <tr><td style="padding:4px 0;">3. Report delivered within promised turnaround — with softcopy download.</td></tr>
          </table>

          <p style="margin:20px 0 0; font-size:12px; color:#6B7280;">Your acknowledgement copy is attached as a PDF.</p>
        </td></tr>
        <tr>
          <td style="background:#0B6B43; color:#FFFFFF; padding:16px 28px; font-size:11px; text-align:center;">
            {{ $lab->address ?? '' }}<br>
            Phone: {{ $lab->phone ?? '' }} | Email: {{ $lab->email ?? '' }}<br>
            {{ $lab->website ?? '' }}
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>

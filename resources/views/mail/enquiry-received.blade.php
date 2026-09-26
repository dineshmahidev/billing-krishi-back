<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="margin:0; padding:0; background:#F3F4F6; font-family:Helvetica,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#F3F4F6; padding:24px 12px;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#FFFFFF; border-radius:16px; overflow:hidden; border:1px solid #E5E7EB;">
        <tr>
          <td style="background:linear-gradient(135deg,#0B6B43,#168B57); padding:26px 28px; color:#FFFFFF;">
            <table width="100%" cellpadding="0" cellspacing="0"><tr>
              <td style="font-size:22px; font-weight:800; letter-spacing:0.5px;">KRISHI ANALYTICAL LAB</td>
              <td align="right" style="font-size:11px; opacity:0.9;">{{ $lab->tagline ?? '' }}</td>
            </tr></table>
            <p style="margin:8px 0 0; font-size:13px; opacity:0.92;">
              {{ $enquiry->isSample() ? 'New Sample Test Request' : 'New Website Enquiry' }}
              <span style="background:#FFFFFF; color:#0B6B43; border-radius:10px; padding:2px 10px; font-weight:700; font-size:11px; margin-left:8px;">{{ $enquiry->ref() }}</span>
            </p>
          </td>
        </tr>
        <tr><td style="padding:24px 28px;">
          <p style="margin:0 0 16px; font-size:14px; color:#374151;">A new submission just arrived from your website. Details below — full copy attached as PDF.</p>
          <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E5E7EB; border-radius:12px; overflow:hidden; font-size:13px;">
            <tr style="background:#EAF7F0;">
              <td style="padding:10px 14px; font-weight:700; color:#0B6B43; width:140px;">Type</td>
              <td style="padding:10px 14px; color:#1F2937;">{{ $enquiry->typeLabel() }}</td>
            </tr>
            <tr>
              <td style="padding:10px 14px; font-weight:700; color:#6B7280; border-top:1px solid #E5E7EB;">Name</td>
              <td style="padding:10px 14px; color:#1F2937; border-top:1px solid #E5E7EB;">{{ $enquiry->name }}</td>
            </tr>
            <tr style="background:#F9FAFB;">
              <td style="padding:10px 14px; font-weight:700; color:#6B7280; border-top:1px solid #E5E7EB;">Phone</td>
              <td style="padding:10px 14px; color:#1F2937; border-top:1px solid #E5E7EB;"><a href="tel:{{ $enquiry->phone }}" style="color:#168B57; font-weight:700;">{{ $enquiry->phone }}</a></td>
            </tr>
            <tr>
              <td style="padding:10px 14px; font-weight:700; color:#6B7280; border-top:1px solid #E5E7EB;">Email</td>
              <td style="padding:10px 14px; color:#1F2937; border-top:1px solid #E5E7EB;">{{ $enquiry->email ?: '—' }}</td>
            </tr>
            @if($enquiry->sample_type)
            <tr style="background:#F9FAFB;">
              <td style="padding:10px 14px; font-weight:700; color:#6B7280; border-top:1px solid #E5E7EB;">Sample</td>
              <td style="padding:10px 14px; color:#1F2937; border-top:1px solid #E5E7EB;">{{ $enquiry->sample_type }}</td>
            </tr>
            @endif
            <tr>
              <td style="padding:10px 14px; font-weight:700; color:#6B7280; border-top:1px solid #E5E7EB; vertical-align:top;">Message</td>
              <td style="padding:10px 14px; color:#1F2937; border-top:1px solid #E5E7EB;">{{ $enquiry->message ?: '—' }}</td>
            </tr>
          </table>
          <p style="margin:18px 0 0; font-size:12px; color:#6B7280;">Received: {{ $enquiry->created_at?->format('d M Y, h:i A') }}</p>
        </td></tr>
        <tr>
          <td style="background:#0B6B43; color:#FFFFFF; padding:14px 28px; font-size:11px; text-align:center;">
            {{ $lab->address ?? '' }}<br>
            {{ $lab->phone ?? '' }} | {{ $lab->email ?? '' }}
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>

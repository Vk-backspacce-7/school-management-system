<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Invitation</title>
</head>
<body style="margin:0;padding:24px;background:#f6f8fb;font-family:Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:24px 24px 12px;">
                            <h2 style="margin:0 0 12px;font-size:24px;color:#111827;">You Are Invited</h2>
                            <p style="margin:0 0 12px;line-height:1.6;">
                                You have been invited to join the School Management System as a teacher.
                            </p>
                            <p style="margin:0 0 24px;line-height:1.6;">
                                Click the button below to complete your registration.
                            </p>
                            <p style="margin:0 0 24px;">
                                <a href="{{ $inviteUrl }}" style="display:inline-block;padding:12px 18px;background:#2563eb;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:bold;">
                                    Complete Registration
                                </a>
                            </p>
                            <p style="margin:0 0 12px;line-height:1.6;color:#4b5563;">
                                If the button does not work, copy and paste this link in your browser:
                            </p>
                            <p style="margin:0 0 12px;line-height:1.6;word-break:break-all;">
                                <a href="{{ $inviteUrl }}">{{ $inviteUrl }}</a>
                            </p>
                            @if($invite->expires_at)
                                <p style="margin:0;line-height:1.6;color:#4b5563;">
                                    This invite expires on {{ $invite->expires_at->timezone(config('app.timezone'))->format('M d, Y h:i A') }}.
                                </p>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

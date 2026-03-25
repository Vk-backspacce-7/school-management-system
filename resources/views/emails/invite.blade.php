<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Invitation</title>

    <style>
        body {
            margin: 0;
            padding: 24px;
            background: #f6f8fb;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 8px;
        }
        h2 {
            margin-bottom: 12px;
            color: #111827;
        }
        p {
            line-height: 1.6;
            margin-bottom: 12px;
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #2563eb;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .link {
            word-break: break-all;
        }
        .muted {
            color: #4b5563;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>You Are Invited</h2>

        <p>
            You have been invited to join the School Management System as a teacher.
        </p>

        <p>
            Click below to complete your registration:
        </p>

        <p>
            <a href="{{ $inviteUrl }}" class="btn">Complete Registration</a>
        </p>

        <p class="muted">
            If the button does not work, use this link:
        </p>

        <p class="link">
            <a href="{{ $inviteUrl }}">{{ $inviteUrl }}</a>
        </p>

        @if($invite->expires_at)
            <p class="muted">
                This invite expires on 
                {{ $invite->expires_at->timezone(config('app.timezone'))->format('M d, Y h:i A') }}.
            </p>
        @endif
    </div>

</body>
</html>
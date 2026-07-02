<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #334155; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #059669;">Your referral link worked!</h2>
    <p>Hello {{ $referrer->name }},</p>
    <p><strong>{{ $newUser->name }}</strong> just verified their account using your referral link.</p>
    <p>Keep sharing your link to grow the Jeeto Rewards community:</p>
    <p style="font-family: monospace; background: #f1f5f9; padding: 12px; border-radius: 8px;">{{ route('register', ['ref' => $referrer->referral_code]) }}</p>
    <p style="margin-top: 24px;">
        <a href="{{ route('dashboard') }}" style="display: inline-block; background: #4f46e5; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;">
            View Dashboard
        </a>
    </p>
</body>
</html>

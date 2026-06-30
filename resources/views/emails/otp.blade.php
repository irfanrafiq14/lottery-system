<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #334155; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #4f46e5;">Email Verification</h2>
    <p>Hello {{ $userName }},</p>
    <p>Your one-time verification code for {{ config('app.name') }} is:</p>
    <p style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #4f46e5; text-align: center; padding: 20px; background: #eef2ff; border-radius: 8px;">{{ $otp }}</p>
    <p>This code expires in <strong>10 minutes</strong>. Do not share it with anyone.</p>
    <p style="color: #64748b; font-size: 14px;">If you did not create an account, please ignore this email.</p>
</body>
</html>

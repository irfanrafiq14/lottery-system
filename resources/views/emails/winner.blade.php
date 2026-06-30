<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #334155; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #059669;">Congratulations, {{ $user->name }}!</h2>
    <p>You are the winner of the <strong>{{ $pool->name }} Pool</strong> draw for {{ $weekLabel }}.</p>
    <div style="background: #ecfdf5; border-radius: 8px; padding: 16px; margin: 20px 0;">
        <p style="margin: 0;"><strong>Pool:</strong> {{ $pool->name }}</p>
        <p style="margin: 8px 0 0;"><strong>Total pool:</strong> {{ number_format($totalPool) }} PKR ({{ $participants }} participants)</p>
        <p style="margin: 8px 0 0;"><strong>Your prize:</strong> {{ number_format($winnerPrize) }} PKR</p>
        <p style="margin: 8px 0 0;"><strong>Week:</strong> {{ $weekLabel }}</p>
    </div>
    <p>Our team will contact you shortly regarding your reward payout.</p>
    <p style="color: #64748b; font-size: 14px;">Thank you for participating in {{ config('app.name') }}.</p>
</body>
</html>

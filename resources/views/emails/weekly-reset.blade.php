<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #334155; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #4f46e5;">New Weekly Draw Started!</h2>
    <p>Hello {{ $user->name }},</p>
    <p>A brand new weekly draw period has begun. Last week's draw for <strong>{{ $weekLabel }}</strong> is complete — here are the winners:</p>

    @if($lastWeekWinners->isNotEmpty())
        <ul style="padding-left: 20px;">
            @foreach($lastWeekWinners as $winner)
                <li><strong>{{ $winner->pool->name }} Pool</strong> — {{ $winner->user->name }}</li>
            @endforeach
        </ul>
    @else
        <p style="color: #64748b;">No winners were selected last week.</p>
    @endif

    <p style="margin-top: 24px;">Join this week's pools and submit your payment proof:</p>
    <ul style="padding-left: 20px;">
        <li><strong>Bronze Pool</strong> — 10 PKR entry</li>
        <li><strong>Silver Pool</strong> — 50 PKR entry</li>
        <li><strong>Gold Pool</strong> — 100 PKR entry</li>
    </ul>

    <p style="margin-top: 24px;">
        <a href="{{ route('dashboard') }}" style="display: inline-block; background: #4f46e5; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;">
            Join Now
        </a>
    </p>

    <p style="color: #64748b; font-size: 14px; margin-top: 24px;">Entries from previous weeks do not carry over. You must re-enter each pool every week.</p>
</body>
</html>

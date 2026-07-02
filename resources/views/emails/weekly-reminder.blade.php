<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #334155; max-width: 600px; margin: 0 auto; padding: 20px;">
    @if($reminderType === 'final')
        <h2 style="color: #dc2626;">Last chance — draw is tomorrow!</h2>
        <p>Hello {{ $user->name }},</p>
        <p>The weekly draw for <strong>{{ $weekLabel }}</strong> happens <strong>Friday at midnight</strong>.</p>
    @else
        <h2 style="color: #4f46e5;">Weekly draw reminder</h2>
        <p>Hello {{ $user->name }},</p>
        <p>Don't miss this week's draw for <strong>{{ $weekLabel }}</strong>.</p>
    @endif

    <p style="font-size: 18px; font-weight: bold; color: #0f172a;">
        Time left: {{ $nextDraw->format('l, M d Y \a\t H:i') }}
    </p>

    @if($hasEntriesThisWeek)
        <p style="color: #059669;">You already have entries this week — good luck in the draw!</p>
    @else
        <p>You haven't joined any pool yet this week. Pick a pool and submit your payment proof before Friday:</p>
        <ul style="padding-left: 20px;">
            @foreach($pools as $pool)
                <li><strong>{{ $pool->name }} Pool</strong> — {{ number_format($pool->entry_fee) }} PKR entry</li>
            @endforeach
        </ul>
    @endif

    <p style="margin-top: 24px;">
        <a href="{{ route('dashboard') }}" style="display: inline-block; background: #4f46e5; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;">
            Go to Dashboard
        </a>
    </p>

    <p style="color: #64748b; font-size: 14px; margin-top: 24px;">Entries reset every week. Re-enter each pool you want to join.</p>
</body>
</html>

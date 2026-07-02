@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-3xl font-bold text-gold-gradient">Reward Pools</h1>
                <p class="mt-1 text-sm text-white/50">{{ $weekLabel }} — Join a pool before the Friday draw</p>
            </div>
            @if(auth()->user()->isEmailVerified())
                <span class="inline-flex items-center gap-1 rounded-full bg-gold/10 px-4 py-1.5 text-xs font-semibold text-gold">
                    <i class="fas fa-check-circle"></i> Verified User
                </span>
            @endif
        </div>
    </div>

    <div class="mb-6 grid gap-6 lg:grid-cols-3">
        <div class="glass-gold glow-pulse rounded-2xl p-6 lg:col-span-2">
            <p class="text-sm font-medium text-gold/80">Next draw countdown</p>
            <div class="mt-3 grid grid-cols-4 gap-3 text-center" id="dashboard-countdown" data-countdown-target="{{ $nextDraw->toIso8601String() }}" data-countdown-parts="1" data-countdown-expired="Draw day — weekly reset in progress">
                @foreach(['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Min', 'seconds' => 'Sec'] as $part => $label)
                    <div class="rounded-xl bg-white/5 px-3 py-3">
                        <p class="font-display text-2xl font-bold text-white" data-countdown-{{ $part }}>0</p>
                        <p class="mt-1 text-xs uppercase tracking-wide text-white/50">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-3 text-sm text-white/50">Every Friday at midnight — 1 winner per pool · You have {{ $userEntriesThisWeek }} {{ $userEntriesThisWeek === 1 ? 'entry' : 'entries' }} this week</p>
        </div>

        <div class="luxury-card p-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-share-nodes text-gold"></i>
                <h2 class="font-display text-lg font-bold">Refer & Earn Friends</h2>
            </div>
            <p class="mt-2 text-sm text-white/60">Share your link. When friends verify their email, you get notified.</p>
            <p class="mt-3 text-xs text-white/40">Your code: <span class="font-mono text-gold">{{ auth()->user()->referral_code }}</span></p>
            <div class="mt-3 flex gap-2">
                <input type="text" readonly value="{{ $referralUrl }}" id="referral-url"
                    class="luxury-input min-w-0 flex-1 px-3 py-2 text-xs text-white">
                <button type="button" onclick="copyReferralLink(this)" class="btn-gold shrink-0 rounded-lg px-3 py-2 text-xs font-semibold">Copy</button>
            </div>
            <p class="mt-3 text-sm text-gold">{{ $referralCount }} verified {{ $referralCount === 1 ? 'referral' : 'referrals' }}</p>
        </div>
    </div>

    @if($lastWeekWinners->isNotEmpty())
        <div class="mb-6 luxury-card border border-gold/20 p-5">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gold/15 text-gold">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gold">Last Friday's Winners</p>
                    <p class="mt-1 text-sm text-white/60">Congratulations to last week's draw winners.</p>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($lastWeekWinners as $winner)
                            <div class="rounded-xl bg-white/5 px-4 py-3">
                                <p class="font-semibold text-white">{{ $winner->user->name }}</p>
                                <p class="text-sm text-gold">{{ $winner->pool->name }} Pool</p>
                                <p class="mt-1 text-lg font-bold text-gold">{{ number_format($winner->prize_amount) }} PKR</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @elseif($isNewWeek)
        <div class="mb-6 luxury-card border border-emerald-500/30 p-5">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <p class="font-semibold text-emerald-300">New Week Started</p>
                    <p class="mt-1 text-sm text-white/60">All pools are open — re-enter to join this week's draw.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($pools as $item)
            @php
                $pool = $item['pool'];
                $accent = match($pool->slug) {
                    'bronze' => 'border-amber-500/30 hover:border-amber-500/60',
                    'silver' => 'border-slate-400/30 hover:border-slate-400/60',
                    'gold' => 'border-gold/40 hover:border-gold/70',
                    default => 'border-purple-500/30',
                };
            @endphp
            <div class="luxury-card border {{ $accent }} p-6 transition hover:-translate-y-1 hover:glow-gold" data-pool-id="{{ $pool->id }}" data-enter-url="{{ route('entries.create', $pool) }}">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-display text-lg font-bold">{{ $pool->name }} Pool</h2>
                    <span data-pool-status-badge class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $pool->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-red-500/20 text-red-300' }}">
                        {{ $pool->statusLabel() }}
                    </span>
                </div>

                <p class="text-3xl font-bold text-white">{{ number_format($pool->entry_fee) }} <span class="text-base font-normal text-white/50">PKR</span></p>

                <x-pool-prize :prize="$item['prize']" simple />

                <div data-pool-action data-user-entry-status="{{ $item['userEntry']?->status ?? 'none' }}">
                @if($item['userEntry'])
                    <div class="mt-4 rounded-lg bg-white/5 px-3 py-2 text-sm text-white/70">
                        Your entry: <span class="font-semibold capitalize text-gold">{{ $item['userEntry']->status }}</span>
                    </div>
                @elseif($pool->is_active)
                    <a href="{{ route('entries.create', $pool) }}" class="btn-gold mt-4 block w-full rounded-xl px-4 py-2.5 text-center text-sm font-semibold">
                        Join Pool
                    </a>
                @else
                    <p class="mt-4 text-center text-sm text-white/40">Entries closed — draw in progress</p>
                @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($recentWinners->isNotEmpty())
        <div class="mt-12" id="recent-winners">
            <h2 class="mb-4 font-display text-xl font-bold text-gold-gradient">Recent Winners</h2>
            <div class="luxury-card overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="border-b border-white/10 text-left text-white/50">
                        <tr>
                            <th class="px-4 py-3 font-medium">Winner</th>
                            <th class="px-4 py-3 font-medium">Pool</th>
                            <th class="px-4 py-3 font-medium">Prize</th>
                            <th class="px-4 py-3 font-medium">Week</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5" id="recent-winners-body">
                        @foreach($recentWinners as $winner)
                            <tr class="hover:bg-white/5">
                                <td class="px-4 py-3">{{ $winner->user->name }}</td>
                                <td class="px-4 py-3 text-gold">{{ $winner->pool->name }}</td>
                                <td class="px-4 py-3 font-semibold text-gold">{{ number_format($winner->prize_amount) }} PKR</td>
                                <td class="px-4 py-3 text-white/60">{{ \App\Support\WeekHelper::formatWeekNumber($winner->week_number) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    function copyReferralLink(btn) {
        const input = document.getElementById('referral-url');
        if (!input) return;
        navigator.clipboard.writeText(input.value).then(() => {
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => { btn.textContent = original; }, 1500);
        });
    }
</script>
@endpush

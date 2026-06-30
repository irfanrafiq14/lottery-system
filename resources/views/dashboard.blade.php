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
                <span class="inline-flex items-center gap-1 rounded-full bg-[#FFD700]/10 px-4 py-1.5 text-xs font-semibold text-[#FFD700]">
                    <i class="fas fa-check-circle"></i> Verified User
                </span>
            @endif
        </div>
    </div>

    @if($isNewWeek)
        <div class="mb-6 luxury-card border border-emerald-500/30 p-5">
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <p class="font-semibold text-emerald-300">New Week Started</p>
                    <p class="mt-1 text-sm text-white/60">Last week's draw is complete. All pools are open — re-enter to join this week's draw.</p>
                    @if($lastWeekWinners->isNotEmpty())
                        <ul class="mt-2 space-y-1 text-sm text-emerald-300/80">
                            @foreach($lastWeekWinners as $winner)
                                <li><strong>{{ $winner->pool->name }}:</strong> {{ $winner->user->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="mb-8 glass-gold glow-pulse rounded-2xl p-6">
        <p class="text-sm font-medium text-[#FFD700]/80">Next draw countdown</p>
        <p class="mt-2 font-display text-3xl font-bold text-white" id="countdown-label">Loading...</p>
        <p class="mt-1 text-sm text-white/50">Every Friday at midnight — 1 winner per pool</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($pools as $item)
            @php
                $pool = $item['pool'];
                $accent = match($pool->slug) {
                    'bronze' => 'border-amber-500/30 hover:border-amber-500/60',
                    'silver' => 'border-slate-400/30 hover:border-slate-400/60',
                    'gold' => 'border-[#FFD700]/40 hover:border-[#FFD700]/70',
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
                        Your entry: <span class="font-semibold capitalize text-[#FFD700]">{{ $item['userEntry']->status }}</span>
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
        <div class="mt-12">
            <h2 class="mb-4 font-display text-xl font-bold text-gold-gradient">Recent Winners</h2>
            <div class="luxury-card overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="border-b border-white/10 text-left text-white/50">
                        <tr>
                            <th class="px-4 py-3 font-medium">Winner</th>
                            <th class="px-4 py-3 font-medium">Pool</th>
                            <th class="px-4 py-3 font-medium">Week</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recentWinners as $winner)
                            <tr class="hover:bg-white/5">
                                <td class="px-4 py-3">{{ $winner->user->name }}</td>
                                <td class="px-4 py-3 text-[#FFD700]">{{ $winner->pool->name }}</td>
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
    const target = new Date('{{ $nextDraw->toIso8601String() }}').getTime();
    const label = document.getElementById('countdown-label');
    function updateCountdown() {
        let diff = target - Date.now();
        if (diff <= 0) { label.textContent = 'Draw day — weekly reset in progress'; return; }
        const d = Math.floor(diff / 86400000); diff -= d * 86400000;
        const h = Math.floor(diff / 3600000); diff -= h * 3600000;
        const m = Math.floor(diff / 60000); diff -= m * 60000;
        const s = Math.floor(diff / 1000);
        label.textContent = `${d}d ${h}h ${m}m ${s}s`;
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endpush

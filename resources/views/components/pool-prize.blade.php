@props(['prize', 'simple' => false])

<div {{ $attributes->merge(['class' => 'mt-3 rounded-xl bg-white/5 px-4 py-3 text-sm border border-[#FFD700]/10', 'data-pool-prize' => '', 'data-pool-prize-simple' => $simple ? '1' : '0']) }}>
    @if($simple)
        <div class="flex items-center justify-between">
            <span class="font-medium text-[#FFD700]/80" data-prize-winner-label>Winner prize</span>
            <span class="text-lg font-bold text-[#FFD700]" data-prize-winner>{{ number_format($prize['winner']) }} PKR</span>
        </div>
    @else
        <div class="flex items-center justify-between text-slate-600">
            <span>Total pool</span>
            <span class="font-semibold text-slate-900" data-prize-total>{{ number_format($prize['total']) }} PKR</span>
        </div>
        <div class="mt-1 flex items-center justify-between text-slate-500">
            <span data-prize-system-label>System ({{ $prize['system_percent'] }}%)</span>
            <span data-prize-system>{{ number_format($prize['system']) }} PKR</span>
        </div>
        <div class="mt-2 flex items-center justify-between border-t border-slate-200 pt-2">
            <span class="font-medium text-emerald-700" data-prize-winner-label>Winner prize ({{ $prize['winner_percent'] }}%)</span>
            <span class="text-lg font-bold text-emerald-700" data-prize-winner>{{ number_format($prize['winner']) }} PKR</span>
        </div>
        <p class="mt-1 text-xs text-slate-400" data-prize-formula>{{ $prize['participants'] }} participants × {{ number_format($prize['entry_fee']) }} PKR</p>
    @endif
</div>

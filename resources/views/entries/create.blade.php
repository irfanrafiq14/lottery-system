@extends('layouts.app')

@section('title', 'Submit Entry')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-gold/70 hover:text-gold">&larr; Back to dashboard</a>
        <h1 class="mt-2 font-display text-2xl font-bold text-gold-gradient">Enter {{ $pool->name }} Pool</h1>
        <p class="text-sm text-white/50">Entry fee: {{ number_format($pool->entry_fee) }} PKR · Week {{ $weekNumber }}</p>
    </div>

    <div class="mx-auto max-w-lg luxury-card p-6">
        <div class="mb-6">
            <h2 class="mb-2 text-sm font-semibold text-gold">Current winner prize</h2>
            <x-pool-prize :prize="$prize" simple />
        </div>

        <div class="mb-6 rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-200">
            Transfer exactly <strong>{{ number_format($pool->entry_fee) }} PKR</strong>
            @if($payment->hasDetails())
                using the details below,
            @endif
            then submit your transaction ID and payment screenshot.
        </div>

        @if($payment->hasDetails())
            <x-payment-details :payment="$payment" />
        @endif

        <form method="POST" action="{{ route('entries.store', $pool) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="transaction_id" class="mb-1 block text-sm font-medium text-white/70">Transaction ID</label>
                <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" required placeholder="e.g. T1234567890"
                    class="luxury-input w-full px-3 py-2.5 text-sm text-white">
                @error('transaction_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="screenshot" class="mb-1 block text-sm font-medium text-white/70">Payment screenshot</label>
                <input type="file" name="screenshot" id="screenshot" accept="image/jpeg,image/jpg,image/png,image/webp" required
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white/70 file:mr-3 file:rounded file:border-0 file:bg-gold/20 file:px-3 file:py-1 file:text-sm file:font-medium file:text-gold">
                @error('screenshot')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                <p class="mt-1 text-xs text-white/40">JPEG, PNG or WebP · Max 5MB</p>
            </div>
            <button type="submit" class="btn-gold w-full rounded-xl px-4 py-2.5 text-sm font-semibold">Submit entry</button>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function copyPayment(elementId, btn) {
        const text = document.getElementById(elementId)?.textContent?.trim();
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => { btn.textContent = original; }, 1500);
        });
    }
</script>
@endpush

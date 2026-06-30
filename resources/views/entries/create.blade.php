@extends('layouts.app')

@section('title', 'Submit Entry')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-[#FFD700]/70 hover:text-[#FFD700]">&larr; Back to dashboard</a>
        <h1 class="mt-2 font-display text-2xl font-bold text-gold-gradient">Enter {{ $pool->name }} Pool</h1>
        <p class="text-sm text-white/50">Entry fee: {{ number_format($pool->entry_fee) }} PKR · Week {{ $weekNumber }}</p>
    </div>

    <div class="mx-auto max-w-lg luxury-card p-6">
        <div class="mb-6">
            <h2 class="mb-2 text-sm font-semibold text-[#FFD700]">Current winner prize</h2>
            <x-pool-prize :prize="$prize" simple />
        </div>

        <div class="mb-6 rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-200">
            Transfer exactly <strong>{{ number_format($pool->entry_fee) }} PKR</strong> via your preferred method, then submit your transaction ID and payment screenshot below.
        </div>

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
                    class="w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white/70 file:mr-3 file:rounded file:border-0 file:bg-[#FFD700]/20 file:px-3 file:py-1 file:text-sm file:font-medium file:text-[#FFD700]">
                @error('screenshot')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                <p class="mt-1 text-xs text-white/40">JPEG, PNG or WebP · Max 5MB</p>
            </div>
            <button type="submit" class="btn-gold w-full rounded-xl px-4 py-2.5 text-sm font-semibold">Submit entry</button>
        </form>
    </div>
@endsection

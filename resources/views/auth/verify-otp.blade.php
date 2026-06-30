@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
    <div class="mb-6 text-center">
        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[#FFD700]/10 text-[#FFD700]">
            <i class="fas fa-envelope text-xl"></i>
        </div>
        <h2 class="font-display text-xl font-semibold text-gold-gradient">Verify your email</h2>
        <p class="mt-2 text-sm text-white/50">We sent a 6-digit OTP to <strong class="text-white">{{ $email }}</strong></p>
    </div>

    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
        @csrf
        <div>
            <label for="otp" class="mb-1 block text-sm font-medium text-white/70">Enter OTP</label>
            <input type="text" name="otp" id="otp" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autofocus placeholder="000000"
                class="luxury-input w-full px-3 py-3 text-center text-2xl tracking-[0.5em] text-white">
            @error('otp')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            <p class="mt-2 text-xs text-white/40">OTP expires in 10 minutes</p>
        </div>
        <button type="submit" class="btn-gold w-full rounded-xl px-4 py-2.5 text-sm font-semibold">Verify email</button>
    </form>

    <form method="POST" action="{{ route('otp.resend') }}" class="mt-4">
        @csrf
        <button type="submit" @disabled(! $canResend) id="resend-btn"
            class="btn-outline-gold w-full rounded-xl px-4 py-2.5 text-sm font-medium disabled:cursor-not-allowed disabled:opacity-50">
            Resend OTP
        </button>
        @if(! $canResend)
            <p class="mt-2 text-center text-xs text-white/40" id="cooldown-text">Wait {{ $cooldownSeconds }}s before resending</p>
        @endif
    </form>
@endsection

@push('scripts')
<script>
    @if(! $canResend)
    let remaining = {{ $cooldownSeconds }};
    const btn = document.getElementById('resend-btn');
    const text = document.getElementById('cooldown-text');
    const interval = setInterval(() => {
        remaining--;
        if (remaining <= 0) { clearInterval(interval); btn.disabled = false; text.textContent = ''; }
        else { text.textContent = `Wait ${remaining}s before resending`; }
    }, 1000);
    @endif
</script>
@endpush

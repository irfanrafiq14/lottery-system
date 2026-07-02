@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <h2 class="mb-6 font-display text-xl font-semibold text-gold-gradient">Create your account</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-white/70">Full name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus class="luxury-input w-full px-3 py-2.5 text-sm text-white">
            @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-white/70">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="luxury-input w-full px-3 py-2.5 text-sm text-white">
            @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-white/70">Password</label>
            <input type="password" name="password" id="password" required class="luxury-input w-full px-3 py-2.5 text-sm text-white">
            @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-white/70">Confirm password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="luxury-input w-full px-3 py-2.5 text-sm text-white">
        </div>

        @if($referralCode)
            <div class="rounded-lg border border-gold/20 bg-gold/5 px-4 py-3 text-sm text-white/70">
                <i class="fas fa-gift mr-1 text-gold"></i>
                Referred by code: <strong class="text-gold">{{ $referralCode }}</strong>
                <input type="hidden" name="referral_code" value="{{ $referralCode }}">
            </div>
        @else
            <div>
                <label for="referral_code" class="mb-1 block text-sm font-medium text-white/70">Referral code <span class="text-white/40">(optional)</span></label>
                <input type="text" name="referral_code" id="referral_code" value="{{ old('referral_code') }}" placeholder="e.g. ABC12345"
                    class="luxury-input w-full px-3 py-2.5 text-sm uppercase text-white">
                @error('referral_code')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
        @endif

        <button type="submit" class="btn-gold w-full rounded-xl px-4 py-2.5 text-sm font-semibold">Create account</button>
    </form>
@endsection

@section('footer')
    Already have an account? <a href="{{ route('login') }}" class="font-medium text-gold hover:underline">Sign in</a>
@endsection

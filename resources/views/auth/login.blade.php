@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h2 class="mb-6 font-display text-xl font-semibold text-gold-gradient">Welcome back</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-white/70">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                class="luxury-input w-full px-3 py-2.5 text-sm text-white">
            @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-white/70">Password</label>
            <input type="password" name="password" id="password" required
                class="luxury-input w-full px-3 py-2.5 text-sm text-white">
            @error('password')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-white/60">
            <input type="checkbox" name="remember" class="rounded border-white/20 bg-white/5 text-gold">
            Remember me
        </label>

        <button type="submit" class="btn-gold w-full rounded-xl px-4 py-2.5 text-sm font-semibold">
            Sign in
        </button>
    </form>
@endsection

@section('footer')
    Don't have an account? <a href="{{ route('register') }}" class="font-medium text-gold hover:underline">Register</a>
@endsection

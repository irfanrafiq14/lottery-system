@extends('layouts.guest')

@section('title', 'Admin Login')

@section('content')
    <h2 class="mb-6 font-display text-xl font-semibold text-gold-gradient">Admin sign in</h2>

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
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
        </div>

        <button type="submit" class="btn-gold w-full rounded-xl px-4 py-2.5 text-sm font-semibold">
            Sign in to admin
        </button>
    </form>
@endsection

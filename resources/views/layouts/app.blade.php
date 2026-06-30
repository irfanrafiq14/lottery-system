<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="realtime-context" content="user">
        <meta name="realtime-user-id" content="{{ auth()->id() }}">
    @endauth
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.theme-vars')
</head>
<body class="min-h-screen bg-[#0a0a0f] text-white antialiased">
    <div class="particles fixed inset-0 pointer-events-none z-0" id="particles"></div>

    <header class="relative z-30 border-b border-white/10 bg-[#0a0a0f]/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ route('dashboard') }}" class="font-display text-xl font-bold text-gold-gradient">{{ config('app.name') }}</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="hidden text-sm text-white/60 hover:text-gold sm:inline">Home</a>
                @auth
                    <span id="realtime-status" class="h-2 w-2 rounded-full bg-slate-500" title="Connecting..."></span>
                    @if(auth()->user()->isEmailVerified())
                        <span class="hidden rounded-full bg-gold/10 px-3 py-1 text-xs font-semibold text-gold sm:inline">
                            <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                    @endif
                    <span class="text-sm text-white/70">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-white/50 hover:text-white">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <main class="relative z-10 mx-auto max-w-6xl px-4 py-8">
        @if(session('success'))
            <div class="mb-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="mb-4 rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-300">{{ session('warning') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>

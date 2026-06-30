<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-[#0a0a0f] px-4 py-8 text-white">
    <div class="absolute inset-0 bg-gradient-to-br from-[#9333EA]/10 via-transparent to-[#FFD700]/5"></div>
    <div class="relative z-10 w-full max-w-md">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="font-display text-2xl font-bold text-gold-gradient">{{ config('app.name') }}</a>
            <p class="mt-2 text-sm text-white/50">Win weekly rewards with Bronze, Silver & Gold pools</p>
        </div>

        <div class="luxury-card p-6 shadow-2xl">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>

        @hasSection('footer')
            <div class="mt-4 text-center text-sm text-white/50">@yield('footer')</div>
        @endif

        <p class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-sm text-[#FFD700]/70 hover:text-[#FFD700]">&larr; Back to home</a>
        </p>
    </div>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="realtime-context" content="admin">
    <meta name="realtime-user-id" content="{{ auth('admin')->id() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="flex min-h-screen flex-col md:flex-row">
        <aside class="border-b border-slate-200 bg-slate-900 text-white md:w-64 md:border-b-0 md:border-r">
            <div class="px-4 py-5">
                <div class="flex items-center gap-2">
                    <span id="realtime-status" class="h-2 w-2 rounded-full bg-slate-300" title="Connecting..."></span>
                    <p class="text-lg font-bold">Admin Panel</p>
                </div>
                <p class="text-xs text-slate-400">{{ config('app.name') }}</p>
            </div>
            <nav class="space-y-1 px-3 pb-6 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800' : '' }}">Dashboard</a>
                <a href="{{ route('admin.entries.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.entries.*') ? 'bg-slate-800' : '' }}">Entries</a>
                <a href="{{ route('admin.pools.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.pools.*') ? 'bg-slate-800' : '' }}">Pools</a>
                <a href="{{ route('admin.settings.edit') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-800' : '' }}">Prize Split</a>
                <a href="{{ route('admin.payment-settings.edit') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.payment-settings.*') ? 'bg-slate-800' : '' }}">Payment Details</a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.users.*') ? 'bg-slate-800' : '' }}">Users</a>
                <a href="{{ route('admin.winners.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.winners.*') ? 'bg-slate-800' : '' }}">Winners</a>
                <a href="{{ route('admin.draw.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.draw.*') ? 'bg-slate-800' : '' }}">Draw</a>
                <a href="{{ route('admin.cms.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.cms.*') ? 'bg-slate-800' : '' }}">Landing CMS</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="px-3 pb-6">
                @csrf
                <button type="submit" class="w-full rounded-lg bg-slate-800 px-3 py-2 text-left text-sm hover:bg-slate-700">Logout</button>
            </form>
        </aside>

        <div class="flex-1">
            <main class="mx-auto max-w-6xl px-4 py-6">
                @if(session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif
                @if(session('warning'))
                    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ session('warning') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

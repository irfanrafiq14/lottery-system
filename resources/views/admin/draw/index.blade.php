@extends('layouts.admin')

@section('title', 'Run Draw')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Weekly Draw & Reset</h1>

    <div class="max-w-xl rounded-xl border border-slate-200 bg-white p-6">
        <p class="text-sm text-slate-500">Current week</p>
        <p class="text-xl font-bold">{{ $weekLabel }}</p>
        <p class="mt-1 text-sm text-slate-500">Next scheduled draw: {{ $nextDraw->format('l, M d Y H:i') }}</p>

        <div class="mt-6 space-y-4">
            <div class="rounded-lg bg-slate-50 px-4 py-3 text-sm text-slate-600">
                <p class="font-medium text-slate-800">Automated weekly flow:</p>
                <ol class="mt-2 list-decimal space-y-1 pl-4">
                    <li>Lock all pools</li>
                    <li>Select 1 winner per pool (approved + verified entries only)</li>
                    <li>Send winner notification emails</li>
                    <li>Soft-delete all entries for the week</li>
                    <li>Reopen pools for the new week</li>
                    <li>Send weekly reset email to all verified users</li>
                </ol>
            </div>

            <form method="POST" action="{{ route('admin.draw.run') }}" onsubmit="return confirm('Run the full weekly draw and reset now?');">
                @csrf
                <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    Run Draw & Reset Manually
                </button>
            </form>

            <form method="POST" action="{{ route('admin.draw.reopen') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium hover:bg-slate-50">
                    Reopen All Pools Only
                </button>
            </form>
        </div>

        <p class="mt-4 text-xs text-slate-500">Scheduled automatically every Friday at 00:00 via <code class="rounded bg-slate-100 px-1">php artisan schedule:run</code></p>
    </div>
@endsection

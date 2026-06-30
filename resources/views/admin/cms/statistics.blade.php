@extends('layouts.admin')

@section('title', 'Statistics')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Statistics Section</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'statistics'])

    <div class="mt-6 max-w-2xl rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-sm text-indigo-800">
        These numbers are calculated automatically from your database and update in real time on the landing page.
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        @foreach([
            'players' => ['Players Joined', 'Unique users with at least one approved entry', 'fa-users'],
            'tickets' => ['Tickets Sold', 'Total approved entries (all weeks)', 'fa-ticket'],
            'winners' => ['Total Winners', 'All weekly draw winners recorded', 'fa-trophy'],
            'prize_paid' => ['Prize Paid (PKR)', 'Sum of prizes locked at each draw (unchanged by later % updates)', 'fa-coins'],
        ] as $key => [$label, $hint, $icon])
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($statistics[$key]) }}</p>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-400">{{ $hint }}</p>
            </div>
        @endforeach
    </div>
@endsection

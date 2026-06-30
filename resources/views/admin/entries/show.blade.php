@extends('layouts.admin')

@section('title', 'Review Entry')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.entries.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to entries</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">Review Entry #{{ $entry->id }}</h1>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="mb-4 font-semibold">Entry Details</h2>
            <dl class="space-y-3 text-sm">
                <div><dt class="text-slate-500">User</dt><dd class="font-medium">{{ $entry->user->name }} ({{ $entry->user->email }})</dd></div>
                <div><dt class="text-slate-500">Pool</dt><dd class="font-medium">{{ $entry->pool->name }} — {{ number_format($entry->pool->entry_fee) }} PKR</dd></div>
                <div><dt class="text-slate-500">Transaction ID</dt><dd class="font-mono">{{ $entry->transaction_id }}</dd></div>
                <div><dt class="text-slate-500">Status</dt><dd class="font-medium capitalize">{{ $entry->status }}</dd></div>
                <div><dt class="text-slate-500">Week</dt><dd>{{ \App\Support\WeekHelper::formatWeekNumber($entry->week_number) }}</dd></div>
                <div><dt class="text-slate-500">Submitted</dt><dd>{{ $entry->created_at->format('M d, Y H:i') }}</dd></div>
            </dl>

            @if($entry->isPending())
                <div class="mt-6 flex gap-3">
                    <form method="POST" action="{{ route('admin.entries.approve', $entry) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.entries.reject', $entry) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Reject</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="mb-4 font-semibold">Payment Screenshot</h2>
            <img src="{{ asset('storage/'.$entry->screenshot) }}" alt="Payment screenshot" class="max-h-96 w-full rounded-lg border border-slate-200 object-contain">
        </div>
    </div>
@endsection

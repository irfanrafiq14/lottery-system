@extends('layouts.admin')

@section('title', 'Manage Entries')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Entries</h1>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Pool</th>
                    <th class="px-4 py-3">Transaction ID</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Week</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($entries as $entry)
                    <tr data-entry-id="{{ $entry->id }}">
                        <td class="px-4 py-3">{{ $entry->user->name }}</td>
                        <td class="px-4 py-3">{{ $entry->pool->name }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $entry->transaction_id }}</td>
                        <td class="px-4 py-3" data-entry-status>
                            <span class="rounded-full px-2 py-0.5 text-xs font-medium capitalize
                                @if($entry->status === 'approved') bg-emerald-100 text-emerald-700
                                @elseif($entry->status === 'rejected') bg-red-100 text-red-700
                                @else bg-amber-100 text-amber-700 @endif">
                                {{ $entry->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $entry->week_number }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.entries.show', $entry) }}" class="text-indigo-600 hover:underline">Review</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $entries->links() }}</div>
@endsection

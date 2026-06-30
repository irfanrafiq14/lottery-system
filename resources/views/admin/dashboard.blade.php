@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Dashboard</h1>

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Total Users</p>
            <p class="text-2xl font-bold" data-stat="users">{{ $stats['users'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Pending Entries</p>
            <p class="text-2xl font-bold text-amber-600" data-stat="pending_entries">{{ $stats['pending_entries'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Approved Entries</p>
            <p class="text-2xl font-bold text-emerald-600" data-stat="approved_entries">{{ $stats['approved_entries'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-sm text-slate-500">Total Winners</p>
            <p class="text-2xl font-bold text-indigo-600" data-stat="winners">{{ $stats['winners'] }}</p>
        </div>
    </div>

    <h2 class="mb-4 text-lg font-semibold">Recent Entries</h2>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Pool</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody id="admin-recent-entries" class="divide-y divide-slate-100">
                @forelse($recentEntries as $entry)
                    <tr data-entry-id="{{ $entry->id }}">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.entries.show', $entry) }}" class="text-indigo-600 hover:underline">{{ $entry->user->name }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $entry->pool->name }}</td>
                        <td class="px-4 py-3 capitalize" data-entry-status>{{ $entry->status }}</td>
                        <td class="px-4 py-3">{{ $entry->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr data-empty-row><td colspan="4" class="px-4 py-6 text-center text-slate-500">No entries yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

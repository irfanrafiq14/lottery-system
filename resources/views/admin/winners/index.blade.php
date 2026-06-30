@extends('layouts.admin')

@section('title', 'Winners History')

@section('content')
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Winners History</h1>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3">Winner</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Pool</th>
                    <th class="px-4 py-3">Week</th>
                    <th class="px-4 py-3">Drawn At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($winners as $winner)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $winner->user->name }}</td>
                        <td class="px-4 py-3">{{ $winner->user->email }}</td>
                        <td class="px-4 py-3">{{ $winner->pool->name }}</td>
                        <td class="px-4 py-3">{{ \App\Support\WeekHelper::formatWeekNumber($winner->week_number) }}</td>
                        <td class="px-4 py-3">{{ $winner->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">No winners yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $winners->links() }}</div>
@endsection

@extends('layouts.admin')

@section('title', 'Manage Pools')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-slate-900">Pools</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.settings.edit') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-white">Prize Split %</a>
            <a href="{{ route('admin.pools.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">+ Add Pool</a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach($pools as $pool)
            @php $prize = $prizes[$pool->id]; @endphp
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-lg font-bold">{{ $pool->name }}</h2>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $pool->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $pool->statusLabel() }}
                    </span>
                </div>
                <p class="text-2xl font-bold">{{ number_format($pool->entry_fee) }} PKR</p>
                <p class="mt-2 text-sm text-slate-500">{{ $pool->approved_entries_count }} approved · {{ $pool->pending_entries_count }} pending</p>

                <x-pool-prize :prize="$prize" class="mt-3" />

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.pools.edit', $pool) }}" class="flex-1 rounded-lg border border-slate-300 px-4 py-2 text-center text-sm font-medium hover:bg-slate-50">Edit</a>
                    <form method="POST" action="{{ route('admin.pools.toggle', $pool) }}" class="flex-1">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-50">
                            {{ $pool->is_active ? 'Close' : 'Open' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

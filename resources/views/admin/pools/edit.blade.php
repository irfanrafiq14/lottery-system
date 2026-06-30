@extends('layouts.admin')

@section('title', 'Edit Pool')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pools.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to pools</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">Edit {{ $pool->name }} Pool</h1>
    </div>

    <div class="mx-auto max-w-lg rounded-xl border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('admin.pools.update', $pool) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Pool name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $pool->name) }}" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="entry_fee" class="mb-1 block text-sm font-medium text-slate-700">Entry fee (PKR)</label>
                <input type="number" name="entry_fee" id="entry_fee" value="{{ old('entry_fee', $pool->entry_fee) }}" required min="1"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('entry_fee')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $pool->is_active)) class="rounded border-slate-300 text-indigo-600">
                Pool is open for entries
            </label>

            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Save changes
            </button>
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('title', $winner->exists ? 'Edit Winner' : 'Add Winner')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">{{ $winner->exists ? 'Edit' : 'Add' }} Landing Winner</h1>
    @include('admin.cms._nav')
    <form method="POST" action="{{ $winner->exists ? route('admin.cms.winners.update', $winner) : route('admin.cms.winners.store') }}" enctype="multipart/form-data" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @if($winner->exists) @method('PUT') @endif
        <div><label class="mb-1 block text-sm font-medium">Name</label><input type="text" name="name" value="{{ old('name', $winner->name) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Prize Amount (PKR)</label><input type="number" name="prize_amount" value="{{ old('prize_amount', $winner->prize_amount) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Country</label><input type="text" name="country" value="{{ old('country', $winner->country) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Pool Name</label><input type="text" name="pool_name" value="{{ old('pool_name', $winner->pool_name) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Won Date</label><input type="date" name="won_at" value="{{ old('won_at', $winner->won_at?->format('Y-m-d')) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Photo</label><input type="file" name="image" accept="image/*" class="w-full text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $winner->sort_order ?? 0) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $winner->is_active ?? true) ? 'checked' : '' }}> Active</label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

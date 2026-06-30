@extends('layouts.admin')

@section('title', $feature->exists ? 'Edit Feature' : 'Add Feature')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">{{ $feature->exists ? 'Edit' : 'Add' }} Feature</h1>
    @include('admin.cms._nav')
    <form method="POST" action="{{ $feature->exists ? route('admin.cms.features.update', $feature) : route('admin.cms.features.store') }}" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @if($feature->exists) @method('PUT') @endif
        <div><label class="mb-1 block text-sm font-medium">Title</label><input type="text" name="title" value="{{ old('title', $feature->title) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Description</label><textarea name="description" rows="3" class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('description', $feature->description) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Icon</label><input type="text" name="icon" value="{{ old('icon', $feature->icon ?? 'fa-shield-halved') }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $feature->sort_order ?? 0) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $feature->is_active ?? true) ? 'checked' : '' }}> Active</label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

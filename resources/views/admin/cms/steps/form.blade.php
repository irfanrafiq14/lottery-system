@extends('layouts.admin')

@section('title', $step->exists ? 'Edit Step' : 'Add Step')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">{{ $step->exists ? 'Edit' : 'Add' }} Step</h1>
    @include('admin.cms._nav')
    <form method="POST" action="{{ $step->exists ? route('admin.cms.steps.update', $step) : route('admin.cms.steps.store') }}" enctype="multipart/form-data" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @if($step->exists) @method('PUT') @endif
        <div><label class="mb-1 block text-sm font-medium">Step Number</label><input type="number" name="step_number" value="{{ old('step_number', $step->step_number) }}" required min="1" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Title</label><input type="text" name="title" value="{{ old('title', $step->title) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Description</label><textarea name="description" rows="3" class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('description', $step->description) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Icon (Font Awesome class)</label><input type="text" name="icon" value="{{ old('icon', $step->icon ?? 'fa-star') }}" required class="w-full rounded-lg border px-3 py-2 text-sm" placeholder="fa-user-plus"></div>
        <div><label class="mb-1 block text-sm font-medium">Image</label><input type="file" name="image" accept="image/*" class="w-full text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $step->sort_order ?? 0) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $step->is_active ?? true) ? 'checked' : '' }} class="rounded"> Active</label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

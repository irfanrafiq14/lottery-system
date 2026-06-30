@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')
    <h1 class="mb-4 text-2xl font-bold">{{ $testimonial->exists ? 'Edit' : 'Add' }} Testimonial</h1>
    @include('admin.cms._nav')
    <form method="POST" action="{{ $testimonial->exists ? route('admin.cms.testimonials.update', $testimonial) : route('admin.cms.testimonials.store') }}" enctype="multipart/form-data" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @if($testimonial->exists) @method('PUT') @endif
        <div><label class="mb-1 block text-sm font-medium">Name</label><input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Country</label><input type="text" name="country" value="{{ old('country', $testimonial->country) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Review</label><textarea name="review" rows="4" required class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('review', $testimonial->review) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Rating (1-5)</label><input type="number" name="rating" value="{{ old('rating', $testimonial->rating ?? 5) }}" min="1" max="5" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Photo</label><input type="file" name="photo" accept="image/*" class="w-full text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}> Active</label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'SEO')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">SEO Settings</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'seo'])
    <form method="POST" action="{{ route('admin.cms.seo.update') }}" enctype="multipart/form-data" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title', $seo['meta_title']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Meta Description</label><textarea name="meta_description" rows="3" required class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('meta_description', $seo['meta_description']) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Keywords</label><input type="text" name="keywords" value="{{ old('keywords', $seo['keywords']) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">OG Image</label><input type="file" name="og_image" accept="image/*" class="w-full text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Favicon</label><input type="file" name="favicon" accept="image/*" class="w-full text-sm"></div>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Analytics & Custom Code</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'analytics'])
    <form method="POST" action="{{ route('admin.cms.analytics.update') }}" class="mt-6 max-w-2xl space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Google Analytics ID</label><input type="text" name="google_analytics" value="{{ old('google_analytics', $analytics['google_analytics']) }}" placeholder="G-XXXXXXXX" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Facebook Pixel ID</label><input type="text" name="facebook_pixel" value="{{ old('facebook_pixel', $analytics['facebook_pixel']) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Custom CSS</label><textarea name="custom_css" rows="6" class="w-full rounded-lg border px-3 py-2 font-mono text-sm">{{ old('custom_css', $analytics['custom_css']) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Custom JS</label><textarea name="custom_js" rows="6" class="w-full rounded-lg border px-3 py-2 font-mono text-sm">{{ old('custom_js', $analytics['custom_js']) }}</textarea></div>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

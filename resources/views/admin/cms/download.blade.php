@extends('layouts.admin')

@section('title', 'Download App')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Download App Section</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'download'])
    <form method="POST" action="{{ route('admin.cms.download.update') }}" enctype="multipart/form-data" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Google Play URL</label><input type="text" name="google_play_url" value="{{ old('google_play_url', $download['google_play_url']) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">App Store URL</label><input type="text" name="app_store_url" value="{{ old('app_store_url', $download['app_store_url']) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">QR Code Image</label><input type="file" name="qr_code" accept="image/*" class="w-full text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Mobile Mockup</label><input type="file" name="mockup_image" accept="image/*" class="w-full text-sm"></div>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

@extends('layouts.admin')

@section('title', 'Footer')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Footer Settings</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'footer'])
    <form method="POST" action="{{ route('admin.cms.footer.update') }}" enctype="multipart/form-data" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Copyright</label><input type="text" name="copyright" value="{{ old('copyright', $footer['copyright']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Contact Email</label><input type="email" name="contact_email" value="{{ old('contact_email', $footer['contact_email']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Contact Phone</label><input type="text" name="contact_phone" value="{{ old('contact_phone', $footer['contact_phone']) }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Logo</label><input type="file" name="logo" accept="image/*" class="w-full text-sm"></div>
        @foreach(['facebook', 'twitter', 'instagram', 'youtube'] as $social)
            <div><label class="mb-1 block text-sm font-medium">{{ ucfirst($social) }} URL</label><input type="text" name="social_{{ $social }}" value="{{ old('social_'.$social, $footer['social'][$social] ?? '') }}" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        @endforeach
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

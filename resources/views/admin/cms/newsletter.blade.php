@extends('layouts.admin')

@section('title', 'Newsletter')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Newsletter Section</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'newsletter'])
    <form method="POST" action="{{ route('admin.cms.newsletter.update') }}" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Title</label><input type="text" name="title" value="{{ old('title', $newsletter['title']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Subtitle</label><textarea name="subtitle" rows="2" required class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('subtitle', $newsletter['subtitle']) }}</textarea></div>
        <div><label class="mb-1 block text-sm font-medium">Button Text</label><input type="text" name="button_text" value="{{ old('button_text', $newsletter['button_text']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

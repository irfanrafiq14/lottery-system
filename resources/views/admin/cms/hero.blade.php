@extends('layouts.admin')

@section('title', 'Hero Section')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Hero Section</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'hero'])

    <form method="POST" action="{{ route('admin.cms.hero.update') }}" enctype="multipart/form-data" class="mt-6 max-w-2xl space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div>
            <label class="mb-1 block text-sm font-medium">Title</label>
            <input type="text" name="title" value="{{ old('title', $hero['title']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Subtitle</label>
            <textarea name="subtitle" rows="2" required class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('subtitle', $hero['subtitle']) }}</textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Primary Button Text</label>
                <input type="text" name="primary_button_text" value="{{ old('primary_button_text', $hero['primary_button_text']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Primary Button URL</label>
                <input type="text" name="primary_button_url" value="{{ old('primary_button_url', $hero['primary_button_url']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Secondary Button Text</label>
                <input type="text" name="secondary_button_text" value="{{ old('secondary_button_text', $hero['secondary_button_text']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Secondary Button URL</label>
                <input type="text" name="secondary_button_url" value="{{ old('secondary_button_url', $hero['secondary_button_url']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Jackpot Label</label>
                <input type="text" name="jackpot_label" value="{{ old('jackpot_label', $hero['jackpot_label']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Fallback Jackpot Amount (PKR)</label>
                <input type="number" name="jackpot_amount" value="{{ old('jackpot_amount', $hero['jackpot_amount']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Lottie Animation URL</label>
            <input type="url" name="lottie_url" value="{{ old('lottie_url', $hero['lottie_url']) }}" class="w-full rounded-lg border px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Background Image</label>
            <input type="file" name="background_image" accept="image/*" class="w-full text-sm">
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="show_confetti" value="1" {{ ($hero['show_confetti'] ?? false) ? 'checked' : '' }} class="rounded">
            Enable confetti effect
        </label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save Hero</button>
    </form>
@endsection

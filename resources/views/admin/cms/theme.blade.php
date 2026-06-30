@extends('layouts.admin')

@section('title', 'Theme')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Theme Settings</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'theme'])
    <form method="POST" action="{{ route('admin.cms.theme.update') }}" class="mt-6 max-w-lg space-y-4 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <div><label class="mb-1 block text-sm font-medium">Primary Color</label><input type="color" name="primary_color" value="{{ old('primary_color', $theme['primary_color']) }}" class="h-10 w-full rounded border"></div>
        <div><label class="mb-1 block text-sm font-medium">Secondary Color</label><input type="color" name="secondary_color" value="{{ old('secondary_color', $theme['secondary_color']) }}" class="h-10 w-full rounded border"></div>
        <div><label class="mb-1 block text-sm font-medium">Heading Font</label><input type="text" name="font_heading" value="{{ old('font_heading', $theme['font_heading']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Body Font</label><input type="text" name="font_body" value="{{ old('font_body', $theme['font_body']) }}" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <div><label class="mb-1 block text-sm font-medium">Animation Speed</label><input type="number" name="animation_speed" value="{{ old('animation_speed', $theme['animation_speed']) }}" step="0.1" min="0.1" max="3" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="dark_mode" value="1" {{ ($theme['dark_mode'] ?? true) ? 'checked' : '' }}> Dark Mode</label>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

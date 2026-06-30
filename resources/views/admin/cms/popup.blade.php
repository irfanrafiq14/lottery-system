@extends('layouts.admin')

@section('title', 'Popup & Site Controls')

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Popup, Announcement & Maintenance</h1>
    @include('admin.cms._nav')
    @include('admin.cms._section_toggle', ['section' => 'popup'])
    <form method="POST" action="{{ route('admin.cms.popup.update') }}" class="mt-6 max-w-2xl space-y-6 rounded-xl border bg-white p-6">
        @csrf @method('PUT')
        <fieldset class="space-y-3 border-b pb-6">
            <legend class="font-semibold text-slate-900">Welcome Popup</legend>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="popup_enabled" value="1" {{ ($popup['enabled'] ?? false) ? 'checked' : '' }}> Enabled</label>
            <input type="text" name="popup_title" value="{{ old('popup_title', $popup['title']) }}" placeholder="Title" required class="w-full rounded-lg border px-3 py-2 text-sm">
            <textarea name="popup_message" rows="2" placeholder="Message" required class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('popup_message', $popup['message']) }}</textarea>
            <div class="grid gap-3 sm:grid-cols-2">
                <input type="text" name="popup_button_text" value="{{ old('popup_button_text', $popup['button_text']) }}" placeholder="Button text" required class="rounded-lg border px-3 py-2 text-sm">
                <input type="text" name="popup_button_url" value="{{ old('popup_button_url', $popup['button_url']) }}" placeholder="Button URL" required class="rounded-lg border px-3 py-2 text-sm">
            </div>
        </fieldset>
        <fieldset class="space-y-3 border-b pb-6">
            <legend class="font-semibold text-slate-900">Announcement Bar</legend>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="announcement_enabled" value="1" {{ ($announcement['enabled'] ?? false) ? 'checked' : '' }}> Enabled</label>
            <input type="text" name="announcement_message" value="{{ old('announcement_message', $announcement['message']) }}" placeholder="Message" class="w-full rounded-lg border px-3 py-2 text-sm">
            <input type="text" name="announcement_link" value="{{ old('announcement_link', $announcement['link']) }}" placeholder="Link URL" class="w-full rounded-lg border px-3 py-2 text-sm">
        </fieldset>
        <fieldset class="space-y-3">
            <legend class="font-semibold text-red-700">Maintenance Mode</legend>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="maintenance_enabled" value="1" {{ ($maintenance['enabled'] ?? false) ? 'checked' : '' }}> Enabled (blocks public site, admin still accessible)</label>
            <textarea name="maintenance_message" rows="2" placeholder="Maintenance message" class="w-full rounded-lg border px-3 py-2 text-sm">{{ old('maintenance_message', $maintenance['message']) }}</textarea>
        </fieldset>
        <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white">Save</button>
    </form>
@endsection

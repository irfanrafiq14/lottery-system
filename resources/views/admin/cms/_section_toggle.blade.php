@props(['section', 'small' => false])

@php
    $enabled = $sectionsEnabled[$section] ?? true;
    $label = \App\Models\SiteSetting::sectionKeys()[$section] ?? ucfirst($section);
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-xl border {{ $enabled ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-slate-50' }} px-5 py-4">
    <div>
        <p class="font-semibold text-slate-900">
            Section status:
            <span class="{{ $enabled ? 'text-emerald-700' : 'text-slate-500' }}">{{ $enabled ? 'Enabled' : 'Disabled' }}</span>
        </p>
        <p class="mt-0.5 text-sm text-slate-500">
            @if(in_array($section, ['seo', 'theme', 'analytics', 'popup']))
                Controls whether {{ $label }} settings are active on the site.
            @else
                Show or hide the <strong>{{ $label }}</strong> block on the landing page.
            @endif
        </p>
    </div>
    <form method="POST" action="{{ route('admin.cms.sections.toggle', $section) }}" class="flex items-center gap-3">
        @csrf
        @method('PATCH')
        <input type="hidden" name="enabled" value="0">
        <label class="admin-toggle {{ $small ? 'admin-toggle-sm' : '' }}">
            <input type="checkbox" name="enabled" value="1" class="admin-toggle-input" {{ $enabled ? 'checked' : '' }} onchange="this.form.submit()">
            <span class="admin-toggle-track"><span class="admin-toggle-thumb"></span></span>
        </label>
        <span class="text-sm font-medium text-slate-700">{{ $enabled ? 'On' : 'Off' }}</span>
    </form>
</div>

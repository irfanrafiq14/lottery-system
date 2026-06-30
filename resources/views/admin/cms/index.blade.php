@extends('layouts.admin')

@section('title', 'Landing Page CMS')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Landing Page CMS</h1>
            <p class="text-sm text-slate-500">Manage content and enable/disable each section on the landing page</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
            <i class="fas fa-external-link-alt mr-1"></i> Preview Site
        </a>
    </div>

    @include('admin.cms._nav')

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach([
            ['Hero Section', 'admin.cms.hero', 'fa-star', 'hero'],
            ['Statistics', 'admin.cms.statistics', 'fa-chart-bar', 'statistics'],
            ['Current Jackpot', 'admin.cms.jackpot', 'fa-coins', 'jackpot'],
            ['How It Works', 'admin.cms.steps.index', 'fa-list-ol', 'steps'],
            ['Why Choose Us', 'admin.cms.features.index', 'fa-shield-halved', 'features'],
            ['Weekly Winners', 'admin.cms.winners.index', 'fa-trophy', 'winners'],
            ['Testimonials', 'admin.cms.testimonials.index', 'fa-quote-left', 'testimonials'],
            ['FAQ', 'admin.cms.faqs.index', 'fa-question-circle', 'faqs'],
            ['Download App', 'admin.cms.download', 'fa-mobile-alt', 'download'],
            ['Newsletter', 'admin.cms.newsletter', 'fa-envelope', 'newsletter'],
            ['Footer', 'admin.cms.footer', 'fa-sitemap', 'footer'],
            ['SEO', 'admin.cms.seo', 'fa-search', 'seo'],
            ['Theme', 'admin.cms.theme', 'fa-palette', 'theme'],
            ['Analytics', 'admin.cms.analytics', 'fa-code', 'analytics'],
            ['Popup & Maintenance', 'admin.cms.popup', 'fa-bell', 'popup'],
        ] as [$label, $route, $icon, $sectionKey])
            @php $isOn = $sectionsEnabled[$sectionKey] ?? true; @endphp
            <div class="rounded-xl border {{ $isOn ? 'border-emerald-200' : 'border-slate-200' }} bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-2">
                    <a href="{{ route($route) }}" class="flex-1 transition hover:opacity-80">
                        <i class="fas {{ $icon }} text-2xl text-indigo-600"></i>
                        <p class="mt-3 font-semibold text-slate-900">{{ $label }}</p>
                    </a>
                    <form method="POST" action="{{ route('admin.cms.sections.toggle', $sectionKey) }}" class="shrink-0" onclick="event.stopPropagation()">
                        @csrf @method('PATCH')
                        <input type="hidden" name="enabled" value="0">
                        <label class="admin-toggle admin-toggle-sm" title="{{ $isOn ? 'Disable section' : 'Enable section' }}">
                            <input type="checkbox" name="enabled" value="1" class="admin-toggle-input" {{ $isOn ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="admin-toggle-track"><span class="admin-toggle-thumb"></span></span>
                        </label>
                    </form>
                </div>
                <p class="mt-2 text-xs font-medium {{ $isOn ? 'text-emerald-600' : 'text-slate-400' }}">
                    {{ $isOn ? 'Enabled on site' : 'Hidden on site' }}
                </p>
            </div>
        @endforeach
    </div>
@endsection

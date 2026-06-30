<nav class="mb-6 flex flex-wrap gap-2 text-sm">
    <a href="{{ route('admin.cms.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.index') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Overview</a>
    <a href="{{ route('admin.cms.hero') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.hero*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Hero</a>
    <a href="{{ route('admin.cms.statistics') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.statistics*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Statistics</a>
    <a href="{{ route('admin.cms.jackpot') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.jackpot*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Jackpot</a>
    <a href="{{ route('admin.cms.steps.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.steps.*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Steps</a>
    <a href="{{ route('admin.cms.features.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.features.*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Features</a>
    <a href="{{ route('admin.cms.winners.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.winners.*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Landing Winners</a>
    <a href="{{ route('admin.cms.testimonials.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.testimonials.*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Testimonials</a>
    <a href="{{ route('admin.cms.faqs.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.faqs.*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">FAQ</a>
    <a href="{{ route('admin.cms.download') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.download*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Download</a>
    <a href="{{ route('admin.cms.newsletter') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.newsletter*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Newsletter</a>
    <a href="{{ route('admin.cms.footer') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.footer*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Footer</a>
    <a href="{{ route('admin.cms.seo') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.seo*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">SEO</a>
    <a href="{{ route('admin.cms.theme') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.theme*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Theme</a>
    <a href="{{ route('admin.cms.analytics') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.analytics*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Analytics</a>
    <a href="{{ route('admin.cms.popup') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.cms.popup*') ? 'bg-indigo-100 text-indigo-700' : 'bg-white text-slate-600 hover:bg-slate-50' }}">Popup & Site</a>
</nav>

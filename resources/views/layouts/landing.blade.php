<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seo['meta_title'] ?? config('app.name') }}</title>
    <meta name="description" content="{{ $seo['meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? '' }}">
    <meta property="og:title" content="{{ $seo['meta_title'] ?? '' }}">
    <meta property="og:description" content="{{ $seo['meta_description'] ?? '' }}">
    @if($ogImage = \App\Services\LandingPageService::assetUrl($seo['og_image'] ?? null))
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    @if($favicon = \App\Services\LandingPageService::assetUrl($seo['favicon'] ?? null))
        <link rel="icon" href="{{ $favicon }}">
    @endif
    @vite(['resources/js/landing.js'])
    @include('partials.theme-vars')
    @if(($sectionsEnabled['analytics'] ?? true) && !empty($analytics['custom_css']))
        <style>{!! $analytics['custom_css'] !!}</style>
    @endif
    @if(($sectionsEnabled['analytics'] ?? true) && !empty($analytics['google_analytics']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analytics['google_analytics'] }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $analytics['google_analytics'] }}');</script>
    @endif
    @if(($sectionsEnabled['analytics'] ?? true) && !empty($analytics['facebook_pixel']))
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','{{ $analytics['facebook_pixel'] }}');fbq('track','PageView');</script>
    @endif
    <script type="application/ld+json">
    {"@@context":"https://schema.org","@@type":"WebSite","name":"{{ config('app.name') }}","description":"{{ $seo['meta_description'] ?? '' }}","url":"{{ url('/') }}"}
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-[#0a0a0f] text-white antialiased overflow-x-hidden">
    <div id="preloader"><div class="preloader-spinner"></div></div>
    <div id="particles" class="particles"></div>
    <div id="cursor-glow" class="cursor-glow hidden md:block"></div>
    <canvas id="confetti-canvas" data-enabled="{{ ($hero['show_confetti'] ?? false) ? '1' : '0' }}" class="fixed inset-0 pointer-events-none z-10"></canvas>

    @if($announcement['enabled'] ?? false)
        <div class="announcement-bar relative z-50 py-2 text-center text-sm font-semibold text-black">
            {{ $announcement['message'] }}
            @if(!empty($announcement['link']))
                <a href="{{ $announcement['link'] }}" class="ml-2 underline">Learn more →</a>
            @endif
        </div>
    @endif

    <header id="site-header" class="fixed top-0 z-40 w-full transition-all duration-300 {{ ($announcement['enabled'] ?? false) ? 'top-8' : 'top-0' }}">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-2xl font-display font-bold text-gold-gradient">{{ config('app.name') }}</span>
            </a>
            <nav class="hidden items-center gap-8 md:flex">
                @if($sectionsEnabled['steps'] ?? true)
                    <a href="#how-it-works" class="text-sm text-white/70 transition hover:text-gold">How It Works</a>
                @endif
                @if($sectionsEnabled['jackpot'] ?? true)
                    <a href="#jackpot" class="text-sm text-white/70 transition hover:text-gold">Jackpot</a>
                @endif
                @if($sectionsEnabled['winners'] ?? true)
                    <a href="#winners" class="text-sm text-white/70 transition hover:text-gold">Winners</a>
                @endif
                @if($sectionsEnabled['faqs'] ?? true)
                    <a href="#faq" class="text-sm text-white/70 transition hover:text-gold">FAQ</a>
                @endif
            </nav>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-gold rounded-full px-5 py-2 text-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden text-sm text-white/70 hover:text-white sm:inline">Login</a>
                    <a href="{{ route('register') }}" class="btn-gold rounded-full px-5 py-2 text-sm">Buy Ticket</a>
                @endauth
            </div>
        </div>
    </header>

    @yield('content')

    @if($sectionsEnabled['footer'] ?? true)
        @include('landing.partials.footer')
    @endif

    <button id="back-to-top" class="btn-gold flex h-12 w-12 items-center justify-center rounded-full shadow-lg" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    @if(($sectionsEnabled['popup'] ?? true) && ($popup['enabled'] ?? false))
        <div x-data="{ open: !sessionStorage.getItem('popup_dismissed') }" x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
            <div class="glass-gold max-w-md rounded-2xl p-8 text-center" data-aos="zoom-in">
                <h3 class="font-display text-2xl font-bold text-gold-gradient">{{ $popup['title'] }}</h3>
                <p class="mt-3 text-white/70">{{ $popup['message'] }}</p>
                <div class="mt-6 flex gap-3 justify-center">
                    <a href="{{ $popup['button_url'] }}" class="btn-gold rounded-full px-6 py-2.5 text-sm">{{ $popup['button_text'] }}</a>
                    <button @click="open=false; sessionStorage.setItem('popup_dismissed','1')" class="btn-outline-gold rounded-full px-6 py-2.5 text-sm">Close</button>
                </div>
            </div>
        </div>
    @endif

    <div id="cookie-consent" class="glass border-t border-white/10 p-4">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4">
            <p class="text-sm text-white/70">We use cookies to improve your experience. By continuing, you agree to our cookie policy.</p>
            <button id="cookie-accept" class="btn-gold rounded-full px-6 py-2 text-sm">Accept</button>
        </div>
    </div>

    @if(($sectionsEnabled['analytics'] ?? true) && !empty($analytics['custom_js']))
        <script>{!! $analytics['custom_js'] !!}</script>
    @endif
    @stack('scripts')
</body>
</html>

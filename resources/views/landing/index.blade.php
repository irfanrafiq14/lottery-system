@php
    $progress = ($jackpot['total_tickets'] ?? 1000) > 0
        ? round((1 - ($jackpot['tickets_remaining'] ?? 0) / ($jackpot['total_tickets'] ?? 1000)) * 100)
        : 0;
    $heroBg = \App\Services\LandingPageService::assetUrl($hero['background_image'] ?? null);
@endphp

@extends('layouts.landing')

@section('content')
    @if($sectionsEnabled['hero'] ?? true)
    {{-- HERO --}}
    <section id="hero" class="relative min-h-screen flex items-center pt-24 pb-16 overflow-hidden">
        @if($heroBg)
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image:url('{{ $heroBg }}')"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-[#9333EA]/20 via-transparent to-[#0a0a0f]"></div>
        <div class="absolute top-1/4 -left-20 h-96 w-96 rounded-full bg-[#9333EA]/20 blur-[120px]"></div>
        <div class="absolute bottom-1/4 -right-20 h-96 w-96 rounded-full bg-[#FFD700]/10 blur-[120px]"></div>

        {{-- Floating lottery balls --}}
        <div class="lottery-ball absolute top-32 left-[10%] animate-float hidden lg:flex">7</div>
        <div class="lottery-ball absolute top-48 right-[15%] animate-float-delay hidden lg:flex">23</div>
        <div class="lottery-ball absolute bottom-32 left-[20%] animate-float-slow hidden lg:flex">42</div>

        <div class="relative z-20 mx-auto grid max-w-7xl gap-12 px-4 lg:grid-cols-2 lg:px-8 lg:items-center">
            <div>
                <h1 class="hero-title font-display text-5xl font-extrabold leading-tight md:text-6xl lg:text-7xl">
                    <span class="text-gold-gradient">{{ $hero['title'] }}</span>
                </h1>
                <p class="hero-subtitle mt-6 text-lg text-white/70 md:text-xl max-w-xl">{{ $hero['subtitle'] }}</p>
                <div class="hero-cta mt-8 flex flex-wrap gap-4">
                    <a href="{{ url($hero['primary_button_url']) }}" class="btn-gold rounded-full px-8 py-3.5 text-base font-bold">
                        <i class="fas fa-ticket mr-2"></i>{{ $hero['primary_button_text'] }}
                    </a>
                    <a href="{{ $hero['secondary_button_url'] }}" class="btn-outline-gold rounded-full px-8 py-3.5 text-base font-semibold">
                        {{ $hero['secondary_button_text'] }}
                    </a>
                </div>

                <div class="hero-jackpot mt-10 glass-gold glow-pulse inline-block rounded-2xl px-8 py-5">
                    <p class="text-sm uppercase tracking-widest text-[#FFD700]/80">{{ $hero['jackpot_label'] }}</p>
                    <p class="mt-1 font-display text-4xl font-bold text-gold-gradient" data-countup="{{ $hero['jackpot_amount'] }}" data-prefix="PKR ">0</p>
                    <p class="mt-3 text-sm text-white/50">
                        <i class="fas fa-clock mr-1 text-[#FFD700]"></i>
                        Draw in: <span id="hero-countdown" class="font-semibold text-white" data-target="{{ $nextDraw->toIso8601String() }}">Loading...</span>
                    </p>
                </div>
            </div>

            <div class="relative flex justify-center">
                <div id="hero-lottie" data-lottie="{{ $hero['lottie_url'] ?? '' }}" class="h-80 w-80 md:h-96 md:w-96"></div>
                <img src="{{ \App\Services\LandingPageService::placeholder('coins.svg') }}" alt="Gold coins" loading="lazy"
                    class="absolute -bottom-4 -right-4 h-24 w-24 rounded-2xl object-cover shadow-2xl animate-float hidden md:block" width="96" height="96">
            </div>
        </div>
    </section>
    @endif

    @if($sectionsEnabled['statistics'] ?? true)
    {{-- STATISTICS --}}
    <section id="statistics" class="relative py-20">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid grid-cols-2 gap-6 lg:grid-cols-4">
                @foreach([
                    ['label' => 'Players Joined', 'value' => $statistics['players'], 'icon' => 'fa-users'],
                    ['label' => 'Tickets Sold', 'value' => $statistics['tickets'], 'icon' => 'fa-ticket'],
                    ['label' => 'Total Winners', 'value' => $statistics['winners'], 'icon' => 'fa-trophy'],
                    ['label' => 'Prize Paid (PKR)', 'value' => $statistics['prize_paid'], 'icon' => 'fa-coins'],
                ] as $stat)
                    <div class="glass-gold rounded-2xl p-6 text-center" data-aos="fade-up">
                        <i class="fas {{ $stat['icon'] }} text-3xl text-[#FFD700]"></i>
                        <p class="mt-4 font-display text-3xl font-bold text-white" data-countup="{{ $stat['value'] }}">0</p>
                        <p class="mt-2 text-sm text-white/60">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($sectionsEnabled['steps'] ?? true)
    {{-- HOW IT WORKS --}}
    <section id="how-it-works" class="relative py-24">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="text-center" data-aos="fade-up">
                <h2 class="font-display text-4xl font-bold text-gold-gradient md:text-5xl">How It Works</h2>
                <p class="mt-4 text-white/60">Four simple steps to your weekly win</p>
            </div>
            <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                @foreach($steps as $step)
                    <div class="group glass-gold rounded-2xl p-6 transition-all duration-300 hover:-translate-y-2 hover:glow-gold" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#FFD700]/10 text-2xl text-[#FFD700] transition group-hover:scale-110">
                            <i class="fas {{ $step->icon }}"></i>
                        </div>
                        <span class="mt-4 inline-block rounded-full bg-[#FFD700]/10 px-3 py-0.5 text-xs font-bold text-[#FFD700]">Step {{ $step->step_number }}</span>
                        <h3 class="mt-3 font-display text-xl font-bold">{{ $step->title }}</h3>
                        <p class="mt-2 text-sm text-white/60">{{ $step->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($sectionsEnabled['jackpot'] ?? true)
    {{-- CURRENT JACKPOT --}}
    <section id="jackpot" class="relative py-24">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            <div class="glass-gold glow-pulse rounded-3xl p-8 md:p-12 text-center" data-aos="zoom-in">
                <h2 class="font-display text-3xl font-bold text-gold-gradient md:text-4xl">{{ $jackpot['title'] }}</h2>
                <p class="mt-6 font-display text-6xl font-extrabold text-white md:text-7xl" data-countup="{{ $jackpot['amount'] }}" data-prefix="PKR ">0</p>
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs uppercase text-white/50">Tickets Remaining</p>
                        <p class="mt-1 text-2xl font-bold text-[#FFD700]">{{ number_format($jackpot['tickets_remaining']) }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs uppercase text-white/50">Draw Date</p>
                        <p class="mt-1 text-lg font-bold">{{ $nextDraw->format('M d, Y') }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs uppercase text-white/50">Est. Winner Prize</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-400">PKR {{ number_format($jackpot['estimated_winner']) }}</p>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="flex justify-between text-sm text-white/60 mb-2">
                        <span>Pool filling up</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="progress-gold h-3">
                        <div class="progress-gold-fill" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-gold mt-8 inline-block rounded-full px-10 py-3.5 text-base font-bold">
                    <i class="fas fa-bolt mr-2"></i>Buy Ticket Now
                </a>
            </div>
        </div>
    </section>
    @endif

    @if(($sectionsEnabled['winners'] ?? true) && $winners->isNotEmpty())
    {{-- WEEKLY WINNERS --}}
    <section id="winners" class="relative py-24 overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="font-display text-4xl font-bold text-gold-gradient">Weekly Winners</h2>
                <p class="mt-4 text-white/60">Real people, real prizes, every Friday</p>
            </div>
            <div class="swiper winners-swiper pb-12">
                <div class="swiper-wrapper">
                    @foreach($winners as $winner)
                        <div class="swiper-slide !w-80">
                            <div class="glass-gold group rounded-2xl overflow-hidden transition hover:-translate-y-2 hover:glow-gold">
                                <div class="relative h-48 bg-gradient-to-br from-[#FFD700]/20 to-[#9333EA]/20 flex items-center justify-center">
                                    @if($img = $winner->imageUrl())
                                        <img src="{{ $img }}" alt="{{ $winner->name }}" class="h-full w-full object-cover" loading="lazy">
                                    @else
                                        <img src="{{ \App\Services\LandingPageService::placeholder('winner-placeholder.svg') }}" alt="Winner" class="h-full w-full object-cover opacity-80" loading="lazy">
                                    @endif
                                    <div class="absolute top-4 right-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#FFD700] text-black shadow-lg">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="font-display text-xl font-bold">{{ $winner->name }}</h3>
                                    <p class="mt-1 text-2xl font-bold text-[#FFD700]">PKR {{ number_format($winner->prize_amount) }}</p>
                                    <div class="mt-3 flex items-center justify-between text-sm text-white/60">
                                        <span><i class="fas fa-globe mr-1"></i>{{ $winner->country ?? '—' }}</span>
                                        <span>{{ $winner->won_at?->format('M d, Y') ?? '—' }}</span>
                                    </div>
                                    @if($winner->pool_name)
                                        <span class="mt-2 inline-block rounded-full bg-[#9333EA]/30 px-3 py-0.5 text-xs text-purple-200">{{ $winner->pool_name }} Pool</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="winners-pagination mt-8 flex justify-center"></div>
            </div>
        </div>
    </section>
    @endif

    @if($sectionsEnabled['features'] ?? true)
    {{-- WHY CHOOSE US --}}
    <section id="features" class="relative py-24">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="text-center" data-aos="fade-up">
                <h2 class="font-display text-4xl font-bold text-gold-gradient">Why Choose Us</h2>
            </div>
            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($features as $feature)
                    <div class="glass rounded-2xl p-6 transition hover:border-[#FFD700]/40 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#FFD700]/10 text-[#FFD700] text-xl">
                            <i class="fas {{ $feature->icon }}"></i>
                        </div>
                        <h3 class="mt-4 font-display text-lg font-bold">{{ $feature->title }}</h3>
                        <p class="mt-2 text-sm text-white/60">{{ $feature->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(($sectionsEnabled['testimonials'] ?? true) && $testimonials->isNotEmpty())
    {{-- TESTIMONIALS --}}
    <section id="testimonials" class="relative py-24">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="font-display text-4xl font-bold text-gold-gradient">What Players Say</h2>
            </div>
            <div class="swiper testimonials-swiper pb-12">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $t)
                        <div class="swiper-slide">
                            <div class="glass-gold rounded-2xl p-6 h-full">
                                <div class="flex items-center gap-4">
                                    @if($photo = $t->photoUrl())
                                        <img src="{{ $photo }}" alt="{{ $t->name }}" class="h-14 w-14 rounded-full object-cover" loading="lazy">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#FFD700]/20 text-[#FFD700] font-bold text-xl">{{ substr($t->name, 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <p class="font-semibold">{{ $t->name }}</p>
                                        <p class="text-sm text-white/50">{{ $t->country }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-[#FFD700]">
                                    @for($i = 0; $i < $t->rating; $i++)<i class="fas fa-star text-sm"></i>@endfor
                                </div>
                                <p class="mt-4 text-sm text-white/70 italic">"{{ $t->review }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="testimonials-pagination flex justify-center mt-6"></div>
            </div>
        </div>
    </section>
    @endif

    @if(($sectionsEnabled['faqs'] ?? true) && $faqs->isNotEmpty())
    {{-- FAQ --}}
    <section id="faq" class="relative py-24">
        <div class="mx-auto max-w-3xl px-4 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="font-display text-4xl font-bold text-gold-gradient">FAQ</h2>
            </div>
            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <div class="faq-item glass rounded-xl overflow-hidden" data-aos="fade-up">
                        <button class="faq-question flex w-full items-center justify-between p-5 text-left font-semibold hover:text-[#FFD700] transition">
                            {{ $faq->question }}
                            <i class="faq-icon fas fa-plus text-[#FFD700] transition-transform"></i>
                        </button>
                        <div class="faq-answer px-5 pb-0 text-sm text-white/60">
                            <p class="pb-5">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($sectionsEnabled['download'] ?? true)
    {{-- DOWNLOAD APP --}}
    <section id="download" class="relative py-24 overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="glass-gold rounded-3xl p-8 md:p-12 grid gap-12 lg:grid-cols-2 items-center" data-aos="fade-up">
                <div>
                    <h2 class="font-display text-3xl font-bold text-gold-gradient md:text-4xl">Download Our App</h2>
                    <p class="mt-4 text-white/60">Play on the go. Get instant draw notifications and manage your tickets anywhere.</p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ $download['google_play_url'] ?? '#' }}" class="flex items-center gap-3 rounded-xl bg-white/10 px-5 py-3 transition hover:bg-white/20">
                            <i class="fab fa-google-play text-2xl text-[#FFD700]"></i>
                            <div><p class="text-xs text-white/50">Get it on</p><p class="font-semibold">Google Play</p></div>
                        </a>
                        <a href="{{ $download['app_store_url'] ?? '#' }}" class="flex items-center gap-3 rounded-xl bg-white/10 px-5 py-3 transition hover:bg-white/20">
                            <i class="fab fa-apple text-2xl text-[#FFD700]"></i>
                            <div><p class="text-xs text-white/50">Download on the</p><p class="font-semibold">App Store</p></div>
                        </a>
                    </div>
                    @if($qr = \App\Services\LandingPageService::assetUrl($download['qr_code'] ?? null))
                        <img src="{{ $qr }}" alt="QR Code" class="mt-6 h-24 w-24 rounded-lg" loading="lazy">
                    @endif
                </div>
                <div class="flex justify-center">
                    @if($mockup = \App\Services\LandingPageService::assetUrl($download['mockup_image'] ?? null))
                        <img src="{{ $mockup }}" alt="Mobile app" class="max-h-96 animate-float-slow" loading="lazy">
                    @else
                        <img src="{{ \App\Services\LandingPageService::placeholder('mobile-mockup.svg') }}" alt="Mobile app mockup" class="max-h-96 animate-float-slow" loading="lazy">
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($sectionsEnabled['newsletter'] ?? true)
    {{-- NEWSLETTER --}}
    <section id="newsletter" class="relative py-24">
        <div class="mx-auto max-w-2xl px-4 text-center lg:px-8" data-aos="fade-up">
            <h2 class="font-display text-3xl font-bold text-gold-gradient">{{ $newsletter['title'] }}</h2>
            <p class="mt-4 text-white/60">{{ $newsletter['subtitle'] }}</p>
            <form id="newsletter-form" action="{{ route('newsletter.subscribe') }}" class="mt-8 flex flex-col gap-3 sm:flex-row">
                <input type="email" name="email" required placeholder="Enter your email"
                    class="luxury-input flex-1 px-5 py-3.5 text-sm text-white">
                <button type="submit" class="btn-gold rounded-full px-8 py-3.5 text-sm font-bold whitespace-nowrap">
                    {{ $newsletter['button_text'] }}
                </button>
            </form>
            <p data-newsletter-msg class="mt-3 text-sm hidden"></p>
        </div>
    </section>
    @endif
@endsection

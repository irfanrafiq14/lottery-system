<footer id="contact" class="relative border-t border-white/10 bg-[#08080c] py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="grid gap-12 md:grid-cols-4">
            <div class="md:col-span-2">
                <p class="font-display text-2xl font-bold text-gold-gradient">{{ config('app.name') }}</p>
                <p class="mt-4 max-w-sm text-sm text-white/50">{{ config('app.name') }} — Pakistan's premium weekly lottery platform. Fair draws, verified winners, fast payouts every Friday.</p>
                <div class="mt-6 flex gap-4">
                    @foreach($footer['social'] ?? [] as $platform => $url)
                        <a href="{{ $url }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-white/60 transition hover:bg-gold/20 hover:text-gold" aria-label="{{ $platform }}">
                            <i class="fab fa-{{ $platform }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h4 class="font-semibold text-gold">Quick Links</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/60">
                    @foreach($footer['links'] ?? [] as $link)
                        <li><a href="{{ $link['url'] }}" class="hover:text-white transition">{{ $link['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Register</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gold">Contact</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/60">
                    <li><i class="fas fa-envelope mr-2 text-gold"></i>{{ $footer['contact_email'] ?? '' }}</li>
                    @if(!empty($footer['contact_phone']))
                        <li><i class="fas fa-phone mr-2 text-gold"></i>{{ $footer['contact_phone'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="mt-12 border-t border-white/10 pt-8 text-center text-sm text-white/40">
            {{ $footer['copyright'] ?? '' }}
        </div>
    </div>
</footer>

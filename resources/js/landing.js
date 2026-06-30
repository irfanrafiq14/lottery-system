import '../css/app.css';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectCoverflow } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-coverflow';
import { CountUp } from 'countup.js';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Alpine from 'alpinejs';
import lottie from 'lottie-web';

gsap.registerPlugin(ScrollTrigger);
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    initPreloader();
    initParticles();
    initHeader();
    initBackToTop();
    initCursorGlow();
    initCountdown();
    initCountUp();
    initSwipers();
    initLottie();
    initGsap();
    initConfetti();
    initCookieConsent();
    initNewsletter();
    initFaqAccordion();

    AOS.init({
        duration: 800,
        once: true,
        offset: 80,
        easing: 'ease-out-cubic',
    });
});

function initPreloader() {
    const preloader = document.getElementById('preloader');
    if (!preloader) return;
    window.addEventListener('load', () => {
        setTimeout(() => preloader.classList.add('hidden'), 600);
    });
}

function initParticles() {
    const container = document.getElementById('particles');
    if (!container) return;
    for (let i = 0; i < 40; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = `${Math.random() * 100}%`;
        p.style.animationDelay = `${Math.random() * 15}s`;
        p.style.animationDuration = `${10 + Math.random() * 10}s`;
        container.appendChild(p);
    }
}

function initHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;
    window.addEventListener('scroll', () => {
        header.classList.toggle('header-scrolled', window.scrollY > 50);
    });
}

function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;
    window.addEventListener('scroll', () => {
        btn.classList.toggle('visible', window.scrollY > 500);
    });
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

function initCursorGlow() {
    const glow = document.getElementById('cursor-glow');
    if (!glow || window.matchMedia('(max-width: 768px)').matches) return;
    document.addEventListener('mousemove', (e) => {
        glow.style.left = `${e.clientX}px`;
        glow.style.top = `${e.clientY}px`;
    });
}

function initCountdown() {
    const el = document.getElementById('hero-countdown');
    const target = el?.dataset.target;
    if (!el || !target) return;

    const end = new Date(target).getTime();
    function tick() {
        const diff = end - Date.now();
        if (diff <= 0) {
            el.textContent = 'Draw happening now!';
            return;
        }
        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        el.textContent = `${d}d ${h}h ${m}m ${s}s`;
    }
    tick();
    setInterval(tick, 1000);
}

function initCountUp() {
    document.querySelectorAll('[data-countup]').forEach((el) => {
        const end = parseFloat(el.dataset.countup);
        const suffix = el.dataset.suffix || '';
        const prefix = el.dataset.prefix || '';
        const countUp = new CountUp(el, end, {
            prefix,
            suffix,
            duration: 2.5,
            separator: ',',
            useGrouping: true,
        });
        ScrollTrigger.create({
            trigger: el,
            start: 'top 85%',
            once: true,
            onEnter: () => countUp.start(),
        });
    });
}

function initSwipers() {
    if (document.querySelector('.winners-swiper')) {
        new Swiper('.winners-swiper', {
            modules: [Navigation, Pagination, Autoplay, EffectCoverflow],
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            coverflowEffect: { rotate: 0, stretch: 0, depth: 100, modifier: 2, slideShadows: false },
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.winners-pagination', clickable: true },
            navigation: { nextEl: '.winners-next', prevEl: '.winners-prev' },
            breakpoints: { 640: { slidesPerView: 1 }, 1024: { slidesPerView: 3 } },
        });
    }

    if (document.querySelector('.testimonials-swiper')) {
        new Swiper('.testimonials-swiper', {
            modules: [Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 24,
            autoplay: { delay: 5000 },
            pagination: { el: '.testimonials-pagination', clickable: true },
            breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        });
    }
}

function initLottie() {
    const container = document.getElementById('hero-lottie');
    const url = container?.dataset.lottie;
    if (!container || !url) return;
    lottie.loadAnimation({
        container,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: url,
    });
}

function initGsap() {
    gsap.from('.hero-title', { y: 60, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.3 });
    gsap.from('.hero-subtitle', { y: 40, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.5 });
    gsap.from('.hero-cta', { y: 30, opacity: 0, duration: 0.8, ease: 'power3.out', delay: 0.7, stagger: 0.15 });
    gsap.from('.hero-jackpot', { scale: 0.8, opacity: 0, duration: 1, ease: 'back.out(1.7)', delay: 0.9 });

    document.querySelectorAll('.lottery-ball').forEach((ball, i) => {
        gsap.to(ball, {
            y: -30,
            rotation: 360,
            duration: 3 + i * 0.5,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: i * 0.3,
        });
    });
}

function initConfetti() {
    const canvas = document.getElementById('confetti-canvas');
    if (!canvas || canvas.dataset.enabled !== '1') return;
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    const rootStyles = getComputedStyle(document.documentElement);
    const themePrimary = rootStyles.getPropertyValue('--theme-primary').trim() || '#FFD700';
    const themeSecondary = rootStyles.getPropertyValue('--theme-secondary').trim() || '#9333EA';
    const pieces = Array.from({ length: 80 }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height - canvas.height,
        w: 8 + Math.random() * 6,
        h: 4 + Math.random() * 4,
        color: [themePrimary, themeSecondary, themePrimary, '#fff'][Math.floor(Math.random() * 4)],
        speed: 1 + Math.random() * 3,
        rot: Math.random() * 360,
    }));

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach((p) => {
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate((p.rot * Math.PI) / 180);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
            ctx.restore();
            p.y += p.speed;
            p.rot += 2;
            if (p.y > canvas.height) p.y = -20;
        });
        requestAnimationFrame(draw);
    }
    draw();
}

function initCookieConsent() {
    const bar = document.getElementById('cookie-consent');
    if (!bar || localStorage.getItem('cookies_accepted')) return;
    setTimeout(() => bar.classList.add('visible'), 2000);
    document.getElementById('cookie-accept')?.addEventListener('click', () => {
        localStorage.setItem('cookies_accepted', '1');
        bar.classList.remove('visible');
    });
}

function initNewsletter() {
    const form = document.getElementById('newsletter-form');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = form.querySelector('[name=email]').value;
        const msg = form.querySelector('[data-newsletter-msg]');
        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    Accept: 'application/json',
                },
                body: JSON.stringify({ email }),
            });
            const data = await res.json();
            if (msg) {
                msg.textContent = data.message || 'Subscribed!';
                msg.classList.remove('hidden', 'text-red-400');
                msg.classList.add('text-emerald-400');
            }
            form.reset();
        } catch {
            if (msg) {
                msg.textContent = 'Something went wrong. Please try again.';
                msg.classList.remove('hidden');
            }
        }
    });
}

function initFaqAccordion() {
    document.querySelectorAll('.faq-item').forEach((item) => {
        item.querySelector('.faq-question')?.addEventListener('click', () => {
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach((i) => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });
}

export { initCountUp, initSwipers };

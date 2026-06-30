<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'hero', 'statistics', 'jackpot', 'download', 'newsletter',
        'footer', 'seo', 'theme', 'analytics', 'popup', 'announcement', 'maintenance', 'sections',
    ];

    protected function casts(): array
    {
        return [
            'hero' => 'array',
            'statistics' => 'array',
            'jackpot' => 'array',
            'download' => 'array',
            'newsletter' => 'array',
            'footer' => 'array',
            'seo' => 'array',
            'theme' => 'array',
            'analytics' => 'array',
            'popup' => 'array',
            'announcement' => 'array',
            'maintenance' => 'array',
            'sections' => 'array',
        ];
    }

    public static function sectionKeys(): array
    {
        return [
            'hero' => 'Hero Section',
            'statistics' => 'Statistics',
            'jackpot' => 'Current Jackpot',
            'steps' => 'How It Works',
            'features' => 'Why Choose Us',
            'winners' => 'Weekly Winners',
            'testimonials' => 'Testimonials',
            'faqs' => 'FAQ',
            'download' => 'Download App',
            'newsletter' => 'Newsletter',
            'footer' => 'Footer',
            'seo' => 'SEO',
            'theme' => 'Theme',
            'analytics' => 'Analytics',
            'popup' => 'Popup & Announcement',
        ];
    }

    public static function defaultSections(): array
    {
        return array_fill_keys(array_keys(static::sectionKeys()), true);
    }

    public static function defaults(): array
    {
        return [
            'hero' => [
                'title' => 'Win Big Every Friday!',
                'subtitle' => 'Join thousands of players and get a chance to become the next weekly winner.',
                'primary_button_text' => 'Buy Ticket',
                'primary_button_url' => '/register',
                'secondary_button_text' => 'How It Works',
                'secondary_button_url' => '#how-it-works',
                'jackpot_label' => 'Current Prize Pool',
                'jackpot_amount' => 250000,
                'background_image' => 'images/landing/hero-bg.svg',
                'hero_video' => null,
                'lottie_url' => 'https://assets10.lottiefiles.com/packages/lf20_touohxv0.json',
                'show_confetti' => true,
            ],
            'statistics' => [
                'players' => 12500,
                'tickets' => 48200,
                'winners' => 156,
                'prize_paid' => 8500000,
            ],
            'jackpot' => [
                'title' => 'Current Jackpot',
                'amount' => 250000,
                'tickets_remaining' => 500,
                'total_tickets' => 1000,
                'draw_date' => null,
                'estimated_winner' => 175000,
            ],
            'download' => [
                'enabled' => true,
                'google_play_url' => '#',
                'app_store_url' => '#',
                'qr_code' => 'images/landing/qr-placeholder.svg',
                'mockup_image' => 'images/landing/mobile-mockup.svg',
            ],
            'newsletter' => [
                'enabled' => true,
                'title' => 'Stay in the Loop',
                'subtitle' => 'Get weekly draw alerts and exclusive offers.',
                'button_text' => 'Subscribe',
            ],
            'footer' => [
                'logo' => 'images/landing/logo-gold.svg',
                'copyright' => '© ' . date('Y') . ' Jeeto Rewards. All rights reserved.',
                'contact_email' => 'support@jeetorewards.test',
                'contact_phone' => '+92 300 1234567',
                'social' => [
                    'facebook' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                    'youtube' => '#',
                ],
                'links' => [
                    ['label' => 'Privacy Policy', 'url' => '#privacy'],
                    ['label' => 'Terms of Service', 'url' => '#terms'],
                    ['label' => 'Support', 'url' => '#support'],
                    ['label' => 'Contact', 'url' => '#contact'],
                ],
            ],
            'seo' => [
                'meta_title' => 'Jeeto Rewards — Win Big Every Friday',
                'meta_description' => 'Join Jeeto Rewards, the premium weekly lottery platform. Fair draws, fast payouts, verified winners.',
                'keywords' => 'lottery, weekly draw, jackpot, rewards, pakistan',
                'og_image' => 'images/landing/og-image.svg',
                'favicon' => 'favicon.ico',
            ],
            'theme' => [
                'primary_color' => '#FFD700',
                'secondary_color' => '#9333EA',
                'font_heading' => 'Playfair Display',
                'font_body' => 'Inter',
                'animation_speed' => 1,
                'dark_mode' => true,
            ],
            'analytics' => [
                'google_analytics' => null,
                'facebook_pixel' => null,
                'custom_js' => null,
                'custom_css' => null,
            ],
            'popup' => [
                'enabled' => false,
                'title' => 'Welcome Bonus!',
                'message' => 'Register today and get your first entry at a special rate.',
                'button_text' => 'Get Started',
                'button_url' => '/register',
            ],
            'announcement' => [
                'enabled' => false,
                'message' => 'Next mega draw this Friday — don\'t miss out!',
                'link' => '/register',
            ],
            'maintenance' => [
                'enabled' => false,
                'message' => 'We are performing scheduled maintenance. Please check back soon.',
            ],
            'sections' => static::defaultSections(),
        ];
    }

    public static function current(): self
    {
        $setting = static::first();

        if (! $setting) {
            $setting = static::create(static::defaults());
        }

        return $setting;
    }

    public function section(string $key): array
    {
        return array_merge(static::defaults()[$key] ?? [], $this->{$key} ?? []);
    }

    public function updateSection(string $key, array $data): void
    {
        $merged = array_merge($this->section($key), $data);
        $this->update([$key => $merged]);
    }

    public function sectionsEnabled(): array
    {
        return array_merge(static::defaultSections(), $this->sections ?? []);
    }

    public function isSectionEnabled(string $key): bool
    {
        return (bool) ($this->sectionsEnabled()[$key] ?? true);
    }

    public function setSectionEnabled(string $key, bool $enabled): void
    {
        abort_unless(array_key_exists($key, static::sectionKeys()), 404);

        $sections = $this->sectionsEnabled();
        $sections[$key] = $enabled;
        $this->update(['sections' => $sections]);
    }
}

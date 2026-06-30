<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\LandingFaq;
use App\Models\LandingFeature;
use App\Models\LandingStep;
use App\Models\LandingTestimonial;
use App\Models\LandingWinner;
use App\Models\Pool;
use App\Models\SiteSetting;
use App\Support\WeekHelper;
use Illuminate\Support\Facades\Storage;

class LandingPageService
{
    public function __construct(
        private PoolPrizeService $prizeService,
        private LandingStatisticsService $statisticsService,
    ) {}

    public function data(): array
    {
        $settings = SiteSetting::current();
        $weekNumber = WeekHelper::currentWeekNumber();
        $pools = Pool::orderBy('entry_fee')->get();

        $totalJackpot = $pools->sum(fn (Pool $pool) => $this->prizeService->prizeForPool($pool, $weekNumber)['winner']);
        $totalTickets = Entry::where('week_number', $weekNumber)->where('status', 'approved')->count();

        $hero = $settings->section('hero');
        $statistics = $this->statisticsService->calculate();
        $jackpot = $settings->section('jackpot');

        $hero['jackpot_amount'] = $totalJackpot > 0 ? $totalJackpot : ($hero['jackpot_amount'] ?? 250000);
        $jackpot['amount'] = $hero['jackpot_amount'];
        $jackpot['draw_date'] = WeekHelper::nextDrawAt()->toIso8601String();
        $jackpot['tickets_remaining'] = max(0, ($jackpot['total_tickets'] ?? 1000) - $totalTickets);

        return [
            'settings' => $settings,
            'sectionsEnabled' => $settings->sectionsEnabled(),
            'hero' => $hero,
            'statistics' => $statistics,
            'jackpot' => $jackpot,
            'download' => $settings->section('download'),
            'newsletter' => $settings->section('newsletter'),
            'footer' => $settings->section('footer'),
            'seo' => $settings->section('seo'),
            'theme' => $settings->section('theme'),
            'analytics' => $settings->section('analytics'),
            'popup' => $settings->section('popup'),
            'announcement' => $settings->section('announcement'),
            'nextDraw' => WeekHelper::nextDrawAt(),
            'steps' => LandingStep::active()->get(),
            'features' => LandingFeature::active()->get(),
            'testimonials' => LandingTestimonial::active()->get(),
            'faqs' => LandingFaq::active()->get(),
            'winners' => LandingWinner::active()->get(),
        ];
    }

    public static function assetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        $publicPath = public_path($path);
        if (file_exists($publicPath)) {
            return asset($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return null;
    }

    public static function placeholder(string $name): string
    {
        $path = "images/landing/{$name}";

        return asset($path);
    }
}

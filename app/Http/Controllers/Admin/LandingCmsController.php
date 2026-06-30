<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\LandingStatisticsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LandingCmsController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.index', [
            'settings' => SiteSetting::current(),
            'sectionsEnabled' => SiteSetting::current()->sectionsEnabled(),
        ]);
    }

    public function toggleSection(Request $request, string $section): RedirectResponse
    {
        abort_unless(array_key_exists($section, SiteSetting::sectionKeys()), 404);

        SiteSetting::current()->setSectionEnabled($section, $request->boolean('enabled'));

        $label = SiteSetting::sectionKeys()[$section];
        $status = $request->boolean('enabled') ? 'enabled' : 'disabled';

        return back()->with('success', "{$label} section {$status}.");
    }

    public function hero(): View
    {
        return view('admin.cms.hero', [
            'hero' => SiteSetting::current()->section('hero'),
        ]);
    }

    public function updateHero(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:500'],
            'primary_button_text' => ['required', 'string', 'max:100'],
            'primary_button_url' => ['required', 'string', 'max:255'],
            'secondary_button_text' => ['required', 'string', 'max:100'],
            'secondary_button_url' => ['required', 'string', 'max:255'],
            'jackpot_label' => ['required', 'string', 'max:100'],
            'jackpot_amount' => ['required', 'integer', 'min:0'],
            'background_image' => ['nullable', 'image', 'max:5120'],
            'hero_video' => ['nullable', 'string', 'max:500'],
            'lottie_url' => ['nullable', 'url', 'max:500'],
            'show_confetti' => ['nullable', 'boolean'],
        ]);

        $data = collect($validated)->except(['background_image'])->toArray();
        $data['show_confetti'] = $request->boolean('show_confetti');

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('landing', 'public');
        } else {
            $data['background_image'] = SiteSetting::current()->section('hero')['background_image'] ?? null;
        }

        SiteSetting::current()->updateSection('hero', $data);

        return back()->with('success', 'Hero section updated.');
    }

    public function statistics(): View
    {
        return view('admin.cms.statistics', [
            'statistics' => app(LandingStatisticsService::class)->calculate(),
        ]);
    }

    public function jackpot(): View
    {
        return view('admin.cms.jackpot', [
            'jackpot' => SiteSetting::current()->section('jackpot'),
        ]);
    }

    public function updateJackpot(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'integer', 'min:0'],
            'tickets_remaining' => ['required', 'integer', 'min:0'],
            'total_tickets' => ['required', 'integer', 'min:1'],
            'estimated_winner' => ['required', 'integer', 'min:0'],
        ]);

        SiteSetting::current()->updateSection('jackpot', $validated);

        return back()->with('success', 'Jackpot section updated.');
    }

    public function download(): View
    {
        return view('admin.cms.download', [
            'download' => SiteSetting::current()->section('download'),
        ]);
    }

    public function updateDownload(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'google_play_url' => ['nullable', 'string', 'max:500'],
            'app_store_url' => ['nullable', 'string', 'max:500'],
            'qr_code' => ['nullable', 'image', 'max:2048'],
            'mockup_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $current = SiteSetting::current()->section('download');
        $data = [
            'google_play_url' => $validated['google_play_url'] ?? '#',
            'app_store_url' => $validated['app_store_url'] ?? '#',
            'qr_code' => $current['qr_code'] ?? null,
            'mockup_image' => $current['mockup_image'] ?? null,
        ];

        if ($request->hasFile('qr_code')) {
            $data['qr_code'] = $request->file('qr_code')->store('landing', 'public');
        }
        if ($request->hasFile('mockup_image')) {
            $data['mockup_image'] = $request->file('mockup_image')->store('landing', 'public');
        }

        SiteSetting::current()->updateSection('download', $data);

        return back()->with('success', 'Download section updated.');
    }

    public function newsletter(): View
    {
        return view('admin.cms.newsletter', [
            'newsletter' => SiteSetting::current()->section('newsletter'),
        ]);
    }

    public function updateNewsletter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:500'],
            'button_text' => ['required', 'string', 'max:100'],
        ]);

        SiteSetting::current()->updateSection('newsletter', $validated);

        return back()->with('success', 'Newsletter section updated.');
    }

    public function footer(): View
    {
        return view('admin.cms.footer', [
            'footer' => SiteSetting::current()->section('footer'),
        ]);
    }

    public function updateFooter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'copyright' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'social_facebook' => ['nullable', 'string', 'max:500'],
            'social_twitter' => ['nullable', 'string', 'max:500'],
            'social_instagram' => ['nullable', 'string', 'max:500'],
            'social_youtube' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $current = SiteSetting::current()->section('footer');
        $data = [
            'copyright' => $validated['copyright'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'] ?? '',
            'logo' => $current['logo'] ?? null,
            'links' => $current['links'] ?? [],
            'social' => [
                'facebook' => $validated['social_facebook'] ?? '#',
                'twitter' => $validated['social_twitter'] ?? '#',
                'instagram' => $validated['social_instagram'] ?? '#',
                'youtube' => $validated['social_youtube'] ?? '#',
            ],
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('landing', 'public');
        }

        SiteSetting::current()->updateSection('footer', $data);

        return back()->with('success', 'Footer updated.');
    }

    public function seo(): View
    {
        return view('admin.cms.seo', [
            'seo' => SiteSetting::current()->section('seo'),
        ]);
    }

    public function updateSeo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:500'],
            'keywords' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'max:5120'],
            'favicon' => ['nullable', 'image', 'max:1024'],
        ]);

        $current = SiteSetting::current()->section('seo');
        $data = collect($validated)->except(['og_image', 'favicon'])->toArray();
        $data['og_image'] = $current['og_image'] ?? null;
        $data['favicon'] = $current['favicon'] ?? null;

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('landing', 'public');
        }
        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('landing', 'public');
        }

        SiteSetting::current()->updateSection('seo', $data);

        return back()->with('success', 'SEO settings updated.');
    }

    public function theme(): View
    {
        return view('admin.cms.theme', [
            'theme' => SiteSetting::current()->section('theme'),
        ]);
    }

    public function updateTheme(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'primary_color' => ['required', 'string', 'max:20'],
            'secondary_color' => ['required', 'string', 'max:20'],
            'font_heading' => ['required', 'string', 'max:100'],
            'font_body' => ['required', 'string', 'max:100'],
            'animation_speed' => ['required', 'numeric', 'min:0.1', 'max:3'],
            'dark_mode' => ['nullable', 'boolean'],
        ]);

        SiteSetting::current()->updateSection('theme', [
            ...$validated,
            'dark_mode' => $request->boolean('dark_mode'),
        ]);

        return back()->with('success', 'Theme settings updated.');
    }

    public function analytics(): View
    {
        return view('admin.cms.analytics', [
            'analytics' => SiteSetting::current()->section('analytics'),
        ]);
    }

    public function updateAnalytics(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'google_analytics' => ['nullable', 'string', 'max:50'],
            'facebook_pixel' => ['nullable', 'string', 'max:50'],
            'custom_js' => ['nullable', 'string', 'max:10000'],
            'custom_css' => ['nullable', 'string', 'max:10000'],
        ]);

        SiteSetting::current()->updateSection('analytics', $validated);

        return back()->with('success', 'Analytics settings updated.');
    }

    public function popup(): View
    {
        return view('admin.cms.popup', [
            'popup' => SiteSetting::current()->section('popup'),
            'announcement' => SiteSetting::current()->section('announcement'),
            'maintenance' => SiteSetting::current()->section('maintenance'),
        ]);
    }

    public function updatePopup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'popup_enabled' => ['nullable', 'boolean'],
            'popup_title' => ['required', 'string', 'max:255'],
            'popup_message' => ['required', 'string', 'max:1000'],
            'popup_button_text' => ['required', 'string', 'max:100'],
            'popup_button_url' => ['required', 'string', 'max:255'],
            'announcement_enabled' => ['nullable', 'boolean'],
            'announcement_message' => ['nullable', 'string', 'max:500'],
            'announcement_link' => ['nullable', 'string', 'max:255'],
            'maintenance_enabled' => ['nullable', 'boolean'],
            'maintenance_message' => ['nullable', 'string', 'max:1000'],
        ]);

        $settings = SiteSetting::current();

        $settings->updateSection('popup', [
            'enabled' => $request->boolean('popup_enabled'),
            'title' => $validated['popup_title'],
            'message' => $validated['popup_message'],
            'button_text' => $validated['popup_button_text'],
            'button_url' => $validated['popup_button_url'],
        ]);

        $settings->updateSection('announcement', [
            'enabled' => $request->boolean('announcement_enabled'),
            'message' => $validated['announcement_message'] ?? '',
            'link' => $validated['announcement_link'] ?? '#',
        ]);

        $settings->updateSection('maintenance', [
            'enabled' => $request->boolean('maintenance_enabled'),
            'message' => $validated['maintenance_message'] ?? '',
        ]);

        return back()->with('success', 'Popup & site controls updated.');
    }
}

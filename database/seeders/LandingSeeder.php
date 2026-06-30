<?php

namespace Database\Seeders;

use App\Models\LandingFaq;
use App\Models\LandingFeature;
use App\Models\LandingStep;
use App\Models\LandingTestimonial;
use App\Models\LandingWinner;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::firstOrCreate([], SiteSetting::defaults());

        $steps = [
            ['step_number' => 1, 'title' => 'Register Account', 'description' => 'Create your free account and verify your email in seconds.', 'icon' => 'fa-user-plus', 'sort_order' => 1],
            ['step_number' => 2, 'title' => 'Purchase Weekly Ticket', 'description' => 'Choose Bronze, Silver or Gold pool and submit payment proof.', 'icon' => 'fa-ticket', 'sort_order' => 2],
            ['step_number' => 3, 'title' => 'Wait Until Friday Draw', 'description' => 'Every Friday at midnight we run a fair random draw.', 'icon' => 'fa-clock', 'sort_order' => 3],
            ['step_number' => 4, 'title' => 'Winner Gets Prize', 'description' => 'One verified winner per pool receives the prize instantly.', 'icon' => 'fa-trophy', 'sort_order' => 4],
        ];

        foreach ($steps as $step) {
            LandingStep::firstOrCreate(['step_number' => $step['step_number']], $step);
        }

        $features = [
            ['title' => '100% Secure', 'description' => 'Bank-grade encryption protects every transaction.', 'icon' => 'fa-shield-halved', 'sort_order' => 1],
            ['title' => 'Fair Draw', 'description' => 'Transparent random selection with verified participants only.', 'icon' => 'fa-scale-balanced', 'sort_order' => 2],
            ['title' => 'Fast Payout', 'description' => 'Winners receive prizes within 24 hours of the draw.', 'icon' => 'fa-bolt', 'sort_order' => 3],
            ['title' => 'Weekly Draw', 'description' => 'Fresh chances every Friday — join any week you like.', 'icon' => 'fa-calendar-week', 'sort_order' => 4],
            ['title' => 'Transparent System', 'description' => 'Full visibility into pool sizes and draw results.', 'icon' => 'fa-eye', 'sort_order' => 5],
            ['title' => 'Verified Winners', 'description' => 'All winners are email-verified real participants.', 'icon' => 'fa-certificate', 'sort_order' => 6],
        ];

        foreach ($features as $feature) {
            LandingFeature::firstOrCreate(['title' => $feature['title']], $feature);
        }

        $testimonials = [
            ['name' => 'Ahmed Khan', 'country' => 'Pakistan', 'review' => 'Won the Gold pool on my third week! Fast payout and amazing experience.', 'rating' => 5, 'sort_order' => 1],
            ['name' => 'Sarah Ali', 'country' => 'UAE', 'review' => 'The most transparent lottery platform I have used. Highly recommended!', 'rating' => 5, 'sort_order' => 2],
            ['name' => 'James Wilson', 'country' => 'UK', 'review' => 'Premium feel, smooth process, and real winners every Friday.', 'rating' => 5, 'sort_order' => 3],
        ];

        foreach ($testimonials as $t) {
            LandingTestimonial::firstOrCreate(['name' => $t['name']], $t);
        }

        $faqs = [
            ['question' => 'How do I participate?', 'answer' => 'Register an account, verify your email, choose a pool (Bronze, Silver, or Gold), pay the entry fee, and submit your transaction ID with a payment screenshot. Once approved, you are in the Friday draw.', 'sort_order' => 1],
            ['question' => 'How are winners selected?', 'answer' => 'Every Friday at midnight, our system randomly selects one verified, approved participant from each active pool. The draw is fully automated and fair.', 'sort_order' => 2],
            ['question' => 'How do I receive payment?', 'answer' => 'Winners are notified by email immediately after the draw. Prize payouts are processed within 24 hours to your registered payment method.', 'sort_order' => 3],
            ['question' => 'Can I play every week?', 'answer' => 'Yes! Each week is a fresh draw. You can enter any or all pools every week. Previous entries do not carry over after the Friday reset.', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            LandingFaq::firstOrCreate(['question' => $faq['question']], $faq);
        }

        $winners = [
            ['name' => 'Fatima R.', 'prize_amount' => 175000, 'country' => 'Pakistan', 'pool_name' => 'Gold', 'won_at' => now()->subWeek(), 'sort_order' => 1],
            ['name' => 'Hassan M.', 'prize_amount' => 42000, 'country' => 'Pakistan', 'pool_name' => 'Silver', 'won_at' => now()->subWeeks(2), 'sort_order' => 2],
            ['name' => 'Ayesha K.', 'prize_amount' => 8400, 'country' => 'Pakistan', 'pool_name' => 'Bronze', 'won_at' => now()->subWeeks(3), 'sort_order' => 3],
        ];

        foreach ($winners as $w) {
            LandingWinner::firstOrCreate(['name' => $w['name'], 'won_at' => $w['won_at']], $w);
        }
    }
}

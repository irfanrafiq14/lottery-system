<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $setting = SiteSetting::first();

        if (! $setting) {
            return;
        }

        $replacements = [
            'Weekly Reward Draw' => 'Jeeto Rewards',
            'WinCircle' => 'Jeeto Rewards',
        ];

        $footer = $setting->footer ?? [];
        if (is_array($footer)) {
            foreach ($replacements as $from => $to) {
                $footer['copyright'] = str_replace($from, $to, $footer['copyright'] ?? '');
            }
            $footer['contact_email'] = str_replace(
                ['rewarddraw.test', 'wincircle.test'],
                'jeetorewards.test',
                $footer['contact_email'] ?? ''
            );
            $setting->footer = $footer;
        }

        $seo = $setting->seo ?? [];
        if (is_array($seo)) {
            foreach ($replacements as $from => $to) {
                $seo['meta_title'] = str_replace($from, $to, $seo['meta_title'] ?? '');
                $seo['meta_description'] = str_replace($from, $to, $seo['meta_description'] ?? '');
            }
            $setting->seo = $seo;
        }

        $setting->save();
    }

    public function down(): void
    {
        //
    }
};

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

        $footer = $setting->footer ?? [];
        if (is_array($footer)) {
            $footer['copyright'] = str_replace('Weekly Reward Draw', 'WinCircle', $footer['copyright'] ?? '');
            $footer['contact_email'] = str_replace('rewarddraw.test', 'wincircle.test', $footer['contact_email'] ?? '');
            $setting->footer = $footer;
        }

        $seo = $setting->seo ?? [];
        if (is_array($seo)) {
            $seo['meta_title'] = str_replace('Weekly Reward Draw', 'WinCircle', $seo['meta_title'] ?? '');
            $seo['meta_description'] = str_replace('Weekly Reward Draw', 'WinCircle', $seo['meta_description'] ?? '');
            $setting->seo = $seo;
        }

        $setting->save();
    }

    public function down(): void
    {
        //
    }
};

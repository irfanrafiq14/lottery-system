<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private array $pathFixes = [
        'images/landing/hero-bg.jpg' => 'images/landing/hero-bg.svg',
        'images/landing/qr-placeholder.png' => 'images/landing/qr-placeholder.svg',
        'images/landing/mobile-mockup.png' => 'images/landing/mobile-mockup.svg',
        'images/landing/og-image.jpg' => 'images/landing/og-image.svg',
    ];

    public function up(): void
    {
        $setting = SiteSetting::first();

        if (! $setting) {
            return;
        }

        foreach (['hero', 'download', 'seo', 'footer'] as $section) {
            $data = $setting->{$section};

            if (! is_array($data)) {
                continue;
            }

            foreach ($data as $key => $value) {
                if (is_string($value) && isset($this->pathFixes[$value])) {
                    $data[$key] = $this->pathFixes[$value];
                }
            }

            $setting->{$section} = $data;
        }

        $setting->save();
    }

    public function down(): void
    {
        //
    }
};

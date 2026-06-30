@php
    $theme = $theme ?? \App\Models\SiteSetting::current()->section('theme');
    $headingFont = $theme['font_heading'] ?? 'Playfair Display';
    $bodyFont = $theme['font_body'] ?? 'Inter';
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family={{ urlencode($bodyFont) }}:wght@400;500;600;700&family={{ urlencode($headingFont) }}:wght@600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --theme-primary: {{ $theme['primary_color'] ?? '#FFD700' }};
        --theme-secondary: {{ $theme['secondary_color'] ?? '#9333EA' }};
        --font-heading: '{{ $headingFont }}', Georgia, serif;
        --font-body: '{{ $bodyFont }}', ui-sans-serif, system-ui, sans-serif;
        --animation-speed: {{ $theme['animation_speed'] ?? 1 }};
    }

    body {
        font-family: var(--font-body);
    }

    .font-display {
        font-family: var(--font-heading);
    }
</style>

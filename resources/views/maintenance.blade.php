<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    @include('partials.theme-vars')
</head>
<body class="flex min-h-screen items-center justify-center bg-[#0a0a0f] text-white">
    <div class="text-center px-4">
        <i class="fas fa-wrench text-5xl text-gold mb-6"></i>
        <h1 class="font-display text-3xl font-bold text-gold-gradient">Under Maintenance</h1>
        <p class="mt-4 text-white/60 max-w-md">{{ $message }}</p>
    </div>
</body>
</html>

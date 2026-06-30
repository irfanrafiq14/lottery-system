<?php

use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureEmailVerified;
use App\Http\Middleware\RedirectIfEmailVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verified.email' => EnsureEmailVerified::class,
            'admin' => EnsureAdmin::class,
            'guest.otp' => RedirectIfEmailVerified::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(fn () => route('dashboard'));
        $middleware->web(append: [CheckMaintenanceMode::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

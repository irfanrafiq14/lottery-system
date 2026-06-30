<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isEmailVerified()) {
            return redirect()->route('otp.show')
                ->with('warning', 'Please verify your email with OTP before continuing.');
        }

        return $next($request);
    }
}

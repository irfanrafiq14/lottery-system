<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/*')) {
            return $next($request);
        }

        $maintenance = SiteSetting::current()->section('maintenance');

        if ($maintenance['enabled'] ?? false) {
            return response()->view('maintenance', [
                'message' => $maintenance['message'] ?? 'Site under maintenance.',
            ], 503);
        }

        return $next($request);
    }
}

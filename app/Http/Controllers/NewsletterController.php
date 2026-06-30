<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        if (! ($newsletter = SiteSetting::current()->section('newsletter')) || ! SiteSetting::current()->isSectionEnabled('newsletter')) {
            return response()->json(['message' => 'Newsletter is currently unavailable.'], 403);
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => $validated['email']],
            ['subscribed_at' => now()],
        );

        return response()->json(['message' => 'Thank you for subscribing!']);
    }
}

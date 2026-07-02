<?php

namespace App\Services;

use App\Mail\ReferralSignupMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ReferralService
{
    public function findReferrer(?string $code): ?User
    {
        if (! filled($code)) {
            return null;
        }

        return User::query()
            ->where('referral_code', strtoupper(trim($code)))
            ->first();
    }

    public function referralUrl(User $user): string
    {
        return route('register', ['ref' => $user->referral_code]);
    }

    public function notifyReferrer(User $newUser): void
    {
        $referrer = $newUser->referrer;

        if (! $referrer || ! $referrer->isEmailVerified()) {
            return;
        }

        Mail::to($referrer->email)->send(new ReferralSignupMail($referrer, $newUser));
    }
}

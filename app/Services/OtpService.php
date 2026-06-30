<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public const OTP_EXPIRY_MINUTES = 10;

    public const RESEND_COOLDOWN_SECONDS = 60;

    public function generateAndSend(User $user): EmailOtp
    {
        EmailOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $emailOtp = EmailOtp::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
            'is_used' => false,
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        Cache::put($this->resendCacheKey($user->id), true, self::RESEND_COOLDOWN_SECONDS);

        return $emailOtp;
    }

    public function verify(User $user, string $otp): bool
    {
        $emailOtp = EmailOtp::where('user_id', $user->id)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $emailOtp) {
            return false;
        }

        $emailOtp->update(['is_used' => true]);

        $user->forceFill(['email_verified_at' => now()])->save();

        return true;
    }

    public function canResend(int $userId): bool
    {
        return ! Cache::has($this->resendCacheKey($userId));
    }

    public function resendCooldownRemaining(int $userId): int
    {
        $expiresAt = Cache::get($this->resendCacheKey($userId).':expires');

        if (! $expiresAt) {
            return 0;
        }

        return max(0, $expiresAt - time());
    }

    public function markResendSent(int $userId): void
    {
        Cache::put($this->resendCacheKey($userId), true, self::RESEND_COOLDOWN_SECONDS);
        Cache::put($this->resendCacheKey($userId).':expires', time() + self::RESEND_COOLDOWN_SECONDS, self::RESEND_COOLDOWN_SECONDS);
    }

    private function resendCacheKey(int $userId): string
    {
        return "otp_resend_{$userId}";
    }
}

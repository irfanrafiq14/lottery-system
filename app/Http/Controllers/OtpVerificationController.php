<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isEmailVerified()) {
            return redirect()->route('dashboard');
        }

        $otpService = app(OtpService::class);
        $canResend = $otpService->canResend($user->id);

        return view('auth.verify-otp', [
            'email' => $user->email,
            'canResend' => $canResend,
            'cooldownSeconds' => OtpService::RESEND_COOLDOWN_SECONDS,
        ]);
    }

    public function verify(Request $request, OtpService $otpService): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ]);

        $user = auth()->user();

        if ($otpService->verify($user, $request->input('otp'))) {
            return redirect()->route('dashboard')
                ->with('success', 'Email verified successfully! You can now join reward pools.');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
    }

    public function resend(OtpService $otpService): RedirectResponse
    {
        $user = auth()->user();

        if ($user->isEmailVerified()) {
            return redirect()->route('dashboard');
        }

        if (! $otpService->canResend($user->id)) {
            return back()->withErrors(['otp' => 'Please wait 60 seconds before requesting a new OTP.']);
        }

        $otpService->generateAndSend($user);

        return back()->with('success', 'A new OTP has been sent to your email.');
    }
}

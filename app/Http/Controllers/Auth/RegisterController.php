<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use App\Services\ReferralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request): View|RedirectResponse
    {
        if ($ref = $request->query('ref')) {
            session(['referral_code' => strtoupper(trim($ref))]);
        }

        $referralCode = old('referral_code', session('referral_code'));

        return view('auth.register', [
            'referralCode' => $referralCode,
        ]);
    }

    public function register(Request $request, OtpService $otpService, ReferralService $referralService): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_code' => ['nullable', 'string', 'max:12'],
        ]);

        $referralInput = $validated['referral_code'] ?? session('referral_code');
        $referrer = $referralService->findReferrer($referralInput);

        if (filled($referralInput) && ! $referrer) {
            return back()
                ->withErrors(['referral_code' => 'Invalid referral code.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'referred_by_id' => $referrer?->id,
        ]);

        session()->forget('referral_code');

        Auth::login($user);

        $otpService->generateAndSend($user);

        return redirect()->route('otp.show')
            ->with('success', 'Account created! Check your email for the verification OTP.');
    }
}

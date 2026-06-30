<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardSetting;
use App\Services\RealtimeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = RewardSetting::current();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request, RealtimeService $realtime): RedirectResponse
    {
        $validated = $request->validate([
            'system_share_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'winner_share_percent' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        if ($validated['system_share_percent'] + $validated['winner_share_percent'] !== 100) {
            return back()->withErrors([
                'system_share_percent' => 'System and winner percentages must add up to 100%.',
            ])->withInput();
        }

        RewardSetting::current()->update($validated);

        $realtime->poolsUpdated();

        return back()->with('success', 'Prize split percentages updated successfully.');
    }
}

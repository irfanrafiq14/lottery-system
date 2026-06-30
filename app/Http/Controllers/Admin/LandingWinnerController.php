<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingWinner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingWinnerController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.winners.index', [
            'winners' => LandingWinner::orderBy('sort_order')->orderByDesc('won_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.winners.form', ['winner' => new LandingWinner()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateWinner($request);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('landing', 'public');
        }
        LandingWinner::create($validated);

        return redirect()->route('admin.cms.winners.index')->with('success', 'Winner created.');
    }

    public function edit(LandingWinner $winner): View
    {
        return view('admin.cms.winners.form', ['winner' => $winner]);
    }

    public function update(Request $request, LandingWinner $winner): RedirectResponse
    {
        $validated = $this->validateWinner($request);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('landing', 'public');
        } else {
            $validated['image'] = $winner->image;
        }
        $winner->update($validated);

        return redirect()->route('admin.cms.winners.index')->with('success', 'Winner updated.');
    }

    public function destroy(LandingWinner $winner): RedirectResponse
    {
        $winner->delete();

        return back()->with('success', 'Winner deleted.');
    }

    private function validateWinner(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prize_amount' => ['required', 'integer', 'min:0'],
            'country' => ['nullable', 'string', 'max:100'],
            'won_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
            'pool_name' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingStepController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.steps.index', [
            'steps' => LandingStep::orderBy('sort_order')->orderBy('step_number')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.steps.form', ['step' => new LandingStep()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateStep($request);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('landing', 'public');
        }
        LandingStep::create($validated);

        return redirect()->route('admin.cms.steps.index')->with('success', 'Step created.');
    }

    public function edit(LandingStep $step): View
    {
        return view('admin.cms.steps.form', ['step' => $step]);
    }

    public function update(Request $request, LandingStep $step): RedirectResponse
    {
        $validated = $this->validateStep($request);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('landing', 'public');
        } else {
            $validated['image'] = $step->image;
        }
        $step->update($validated);

        return redirect()->route('admin.cms.steps.index')->with('success', 'Step updated.');
    }

    public function destroy(LandingStep $step): RedirectResponse
    {
        $step->delete();

        return back()->with('success', 'Step deleted.');
    }

    private function validateStep(Request $request): array
    {
        return $request->validate([
            'step_number' => ['required', 'integer', 'min:1', 'max:10'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

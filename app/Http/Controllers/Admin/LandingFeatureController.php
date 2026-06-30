<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingFeatureController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.features.index', [
            'features' => LandingFeature::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.features.form', ['feature' => new LandingFeature()]);
    }

    public function store(Request $request): RedirectResponse
    {
        LandingFeature::create($this->validateFeature($request));

        return redirect()->route('admin.cms.features.index')->with('success', 'Feature created.');
    }

    public function edit(LandingFeature $feature): View
    {
        return view('admin.cms.features.form', ['feature' => $feature]);
    }

    public function update(Request $request, LandingFeature $feature): RedirectResponse
    {
        $feature->update($this->validateFeature($request));

        return redirect()->route('admin.cms.features.index')->with('success', 'Feature updated.');
    }

    public function destroy(LandingFeature $feature): RedirectResponse
    {
        $feature->delete();

        return back()->with('success', 'Feature deleted.');
    }

    private function validateFeature(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

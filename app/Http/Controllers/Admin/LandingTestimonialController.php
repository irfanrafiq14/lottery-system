<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingTestimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingTestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.testimonials.index', [
            'testimonials' => LandingTestimonial::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.testimonials.form', ['testimonial' => new LandingTestimonial()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('landing', 'public');
        }
        LandingTestimonial::create($validated);

        return redirect()->route('admin.cms.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(LandingTestimonial $testimonial): View
    {
        return view('admin.cms.testimonials.form', ['testimonial' => $testimonial]);
    }

    public function update(Request $request, LandingTestimonial $testimonial): RedirectResponse
    {
        $validated = $this->validateTestimonial($request);
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('landing', 'public');
        } else {
            $validated['photo'] = $testimonial->photo;
        }
        $testimonial->update($validated);

        return redirect()->route('admin.cms.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(LandingTestimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted.');
    }

    private function validateTestimonial(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'review' => ['required', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

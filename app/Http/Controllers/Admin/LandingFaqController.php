<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingFaq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingFaqController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.faqs.index', [
            'faqs' => LandingFaq::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.faqs.form', ['faq' => new LandingFaq()]);
    }

    public function store(Request $request): RedirectResponse
    {
        LandingFaq::create($this->validateFaq($request));

        return redirect()->route('admin.cms.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(LandingFaq $faq): View
    {
        return view('admin.cms.faqs.form', ['faq' => $faq]);
    }

    public function update(Request $request, LandingFaq $faq): RedirectResponse
    {
        $faq->update($this->validateFaq($request));

        return redirect()->route('admin.cms.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(LandingFaq $faq): RedirectResponse
    {
        $faq->delete();

        return back()->with('success', 'FAQ deleted.');
    }

    private function validateFaq(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string', 'max:5000'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}

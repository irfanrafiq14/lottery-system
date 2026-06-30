<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Services\RealtimeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function index(): View
    {
        $entries = Entry::with(['user', 'pool'])
            ->latest()
            ->paginate(20);

        return view('admin.entries.index', compact('entries'));
    }

    public function show(Entry $entry): View
    {
        $entry->load(['user', 'pool']);

        return view('admin.entries.show', compact('entry'));
    }

    public function approve(Entry $entry, RealtimeService $realtime): RedirectResponse
    {
        if ($entry->status !== 'pending') {
            return back()->with('error', 'Only pending entries can be approved.');
        }

        $entry->update(['status' => 'approved']);
        $realtime->entryStatusChanged($entry->fresh());

        return back()->with('success', 'Entry approved successfully.');
    }

    public function reject(Entry $entry, RealtimeService $realtime): RedirectResponse
    {
        if ($entry->status !== 'pending') {
            return back()->with('error', 'Only pending entries can be rejected.');
        }

        $entry->update(['status' => 'rejected']);
        $realtime->entryStatusChanged($entry->fresh());

        return back()->with('success', 'Entry rejected.');
    }
}

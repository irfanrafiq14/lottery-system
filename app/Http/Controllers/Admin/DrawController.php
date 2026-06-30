<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DrawService;
use App\Services\WeeklyDrawService;
use App\Support\WeekHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DrawController extends Controller
{
    public function index(): View
    {
        return view('admin.draw.index', [
            'currentWeek' => WeekHelper::currentWeekNumber(),
            'weekLabel' => WeekHelper::formatWeekNumber(WeekHelper::currentWeekNumber()),
            'nextDraw' => WeekHelper::nextDrawAt(),
        ]);
    }

    public function run(WeeklyDrawService $weeklyDrawService): RedirectResponse
    {
        $result = $weeklyDrawService->execute();

        if ($result['winners']->isEmpty()) {
            return back()->with('warning', 'Draw completed with no winners. Entries reset and pools reopened. Reset emails sent to all verified users.');
        }

        $count = $result['winners']->count();

        return back()->with('success', "Draw completed! {$count} winner(s) selected, {$result['deleted_entries']} entries archived, reset emails sent to {$result['reset_emails_sent']} users.");
    }

    public function reopenPools(DrawService $drawService): RedirectResponse
    {
        $drawService->openAllPools();

        return back()->with('success', 'All pools have been reopened for entries.');
    }
}

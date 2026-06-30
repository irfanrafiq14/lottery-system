<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'pending_entries' => Entry::where('status', 'pending')->count(),
            'approved_entries' => Entry::where('status', 'approved')->count(),
            'winners' => Winner::count(),
        ];

        $recentEntries = Entry::with(['user', 'pool'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentEntries'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Winner;
use Illuminate\View\View;

class WinnerController extends Controller
{
    public function index(): View
    {
        $winners = Winner::with(['user', 'pool'])
            ->latest()
            ->paginate(20);

        return view('admin.winners.index', compact('winners'));
    }
}

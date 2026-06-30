<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\PaymentSetting;
use App\Models\Pool;
use App\Services\PoolPrizeService;
use App\Services\RealtimeService;
use App\Support\WeekHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function create(Pool $pool, PoolPrizeService $prizeService): View|RedirectResponse
    {
        if (! $pool->is_active) {
            return redirect()->route('dashboard')
                ->with('error', 'This pool is currently closed for entries.');
        }

        $weekNumber = WeekHelper::currentWeekNumber();

        $existingEntry = Entry::where('user_id', auth()->id())
            ->where('pool_id', $pool->id)
            ->where('week_number', $weekNumber)
            ->first();

        if ($existingEntry) {
            return redirect()->route('dashboard')
                ->with('warning', 'You have already submitted an entry for this pool this week.');
        }

        $prize = $prizeService->prizeForPool($pool, $weekNumber);
        $payment = PaymentSetting::current();

        return view('entries.create', compact('pool', 'weekNumber', 'prize', 'payment'));
    }

    public function store(Request $request, Pool $pool, RealtimeService $realtime): RedirectResponse
    {
        if (! $pool->is_active) {
            return redirect()->route('dashboard')
                ->with('error', 'This pool is currently closed for entries.');
        }

        $weekNumber = WeekHelper::currentWeekNumber();

        $validated = $request->validate([
            'transaction_id' => [
                'required',
                'string',
                'max:100',
                Rule::unique('entries', 'transaction_id')->whereNull('deleted_at'),
            ],
            'screenshot' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],
        ]);

        $existingEntry = Entry::where('user_id', auth()->id())
            ->where('pool_id', $pool->id)
            ->where('week_number', $weekNumber)
            ->exists();

        if ($existingEntry) {
            return redirect()->route('dashboard')
                ->with('warning', 'You have already submitted an entry for this pool this week.');
        }

        $path = $request->file('screenshot')->store('payments', 'public');

        $entry = Entry::create([
            'user_id' => auth()->id(),
            'pool_id' => $pool->id,
            'transaction_id' => $validated['transaction_id'],
            'screenshot' => $path,
            'status' => 'pending',
            'week_number' => $weekNumber,
        ]);

        $realtime->entryCreated($entry);

        return redirect()->route('dashboard')
            ->with('success', 'Entry submitted! Admin will review your payment shortly.');
    }
}

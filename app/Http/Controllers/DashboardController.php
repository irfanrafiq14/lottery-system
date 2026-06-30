<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Pool;
use App\Models\RewardSetting;
use App\Models\Winner;
use App\Services\PoolPrizeService;
use App\Support\WeekHelper;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(PoolPrizeService $prizeService): View
    {
        $weekNumber = WeekHelper::currentWeekNumber();
        $user = auth()->user();
        $settings = RewardSetting::current();

        $pools = Pool::orderBy('entry_fee')->get()->map(function (Pool $pool) use ($weekNumber, $user, $prizeService) {
            $userEntry = Entry::where('user_id', $user->id)
                ->where('pool_id', $pool->id)
                ->where('week_number', $weekNumber)
                ->first();

            return [
                'pool' => $pool,
                'participants' => $pool->participantCount($weekNumber),
                'userEntry' => $userEntry,
                'prize' => $prizeService->prizeForPool($pool, $weekNumber),
            ];
        });

        $lastWeekWinners = Winner::with(['user', 'pool'])
            ->where('week_number', WeekHelper::weekNumberFromDate(WeekHelper::lastDrawAt()))
            ->get();

        $recentWinners = Winner::with(['user', 'pool'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', [
            'pools' => $pools,
            'settings' => $settings,
            'nextDraw' => WeekHelper::nextDrawAt(),
            'weekNumber' => $weekNumber,
            'weekLabel' => WeekHelper::formatWeekNumber($weekNumber),
            'isNewWeek' => WeekHelper::isNewWeekPeriod(),
            'lastWeekWinners' => $lastWeekWinners,
            'recentWinners' => $recentWinners,
        ]);
    }
}

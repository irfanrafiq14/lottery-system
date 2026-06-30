<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\Pool;
use App\Models\Winner;
use Illuminate\Support\Collection;

class DrawService
{
    public function lockAllPools(): void
    {
        Pool::query()->update(['is_active' => false]);
    }

    public function openAllPools(): void
    {
        Pool::query()->update(['is_active' => true]);
    }

    /**
     * @return Collection<int, Winner>
     */
    public function selectWinners(int $weekNumber): Collection
    {
        $winners = collect();

        foreach (Pool::all() as $pool) {
            if (Winner::where('pool_id', $pool->id)->where('week_number', $weekNumber)->exists()) {
                continue;
            }

            $eligibleEntries = $pool->approvedEntriesForWeek($weekNumber)->get();

            if ($eligibleEntries->isEmpty()) {
                continue;
            }

            $winningEntry = $eligibleEntries->random();

            $winners->push(Winner::create([
                'user_id' => $winningEntry->user_id,
                'pool_id' => $pool->id,
                'week_number' => $weekNumber,
            ]));
        }

        return $winners;
    }

    public function softDeleteEntriesForWeek(int $weekNumber): int
    {
        return Entry::where('week_number', $weekNumber)->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Pool;
use App\Support\WeekHelper;

class PoolPrizeService
{
    public function prizeForPool(Pool $pool, ?int $weekNumber = null): array
    {
        $weekNumber = $weekNumber ?? WeekHelper::currentWeekNumber();
        $participants = $pool->participantCount($weekNumber);
        $split = $pool->effectiveSplit();

        $total = $participants * $pool->entry_fee;
        $system = (int) round($total * $split['system_share_percent'] / 100);
        $winner = (int) round($total * $split['winner_share_percent'] / 100);

        return [
            'total' => $total,
            'system' => $system,
            'winner' => $winner,
            'participants' => $participants,
            'entry_fee' => $pool->entry_fee,
            'system_percent' => $split['system_share_percent'],
            'winner_percent' => $split['winner_share_percent'],
            'uses_default_split' => $pool->usesDefaultSplit(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function prizePayload(Pool $pool, ?int $weekNumber = null): array
    {
        $prize = $this->prizeForPool($pool, $weekNumber);

        return [
            'total_pool' => $prize['total'],
            'system_amount' => $prize['system'],
            'winner_prize' => $prize['winner'],
            'participants' => $prize['participants'],
            'system_percent' => $prize['system_percent'],
            'winner_percent' => $prize['winner_percent'],
        ];
    }
}

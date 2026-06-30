<?php

namespace App\Services;

use App\Models\Pool;
use App\Models\RewardSetting;
use App\Support\WeekHelper;

class PoolPrizeService
{
    public function prizeForPool(Pool $pool, ?int $weekNumber = null): array
    {
        $weekNumber = $weekNumber ?? WeekHelper::currentWeekNumber();
        $participants = $pool->participantCount($weekNumber);
        $settings = RewardSetting::current();

        return array_merge(
            $settings->calculatePrize($participants, $pool->entry_fee),
            [
                'entry_fee' => $pool->entry_fee,
                'system_percent' => $settings->system_share_percent,
                'winner_percent' => $settings->winner_share_percent,
            ]
        );
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

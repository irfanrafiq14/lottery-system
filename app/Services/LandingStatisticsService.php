<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\RewardSetting;
use App\Models\User;
use App\Models\Winner;

class LandingStatisticsService
{
    /**
     * Live landing-page statistics from the database.
     *
     * @return array{players: int, tickets: int, winners: int, prize_paid: int}
     */
    public function calculate(): array
    {
        $approvedEntries = Entry::withTrashed()->where('status', 'approved');

        $tickets = (clone $approvedEntries)->count();

        $players = (clone $approvedEntries)->distinct()->count('user_id');

        $winners = Winner::count();

        $prizePaid = $this->totalPrizePaid();

        return [
            'players' => $players,
            'tickets' => $tickets,
            'winners' => $winners,
            'prize_paid' => $prizePaid,
        ];
    }

    private function totalPrizePaid(): int
    {
        $settings = RewardSetting::current();

        return Winner::query()
            ->with('pool')
            ->get()
            ->sum(function (Winner $winner) use ($settings) {
                if (! $winner->pool) {
                    return 0;
                }

                $participants = Entry::withTrashed()
                    ->where('pool_id', $winner->pool_id)
                    ->where('week_number', $winner->week_number)
                    ->where('status', 'approved')
                    ->count();

                return $settings->calculatePrize($participants, $winner->pool->entry_fee)['winner'];
            });
    }
}

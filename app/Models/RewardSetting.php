<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardSetting extends Model
{
    protected $fillable = [
        'system_share_percent',
        'winner_share_percent',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'system_share_percent' => 30,
            'winner_share_percent' => 70,
        ]);
    }

    /**
     * @return array{total: int, system: int, winner: int, participants: int}
     */
    public function calculatePrize(int $participants, int $entryFee): array
    {
        $total = $participants * $entryFee;
        $system = (int) round($total * $this->system_share_percent / 100);
        $winner = (int) round($total * $this->winner_share_percent / 100);

        return [
            'total' => $total,
            'system' => $system,
            'winner' => $winner,
            'participants' => $participants,
        ];
    }
}

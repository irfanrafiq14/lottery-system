<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pool extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'entry_fee',
        'system_share_percent',
        'winner_share_percent',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function usesDefaultSplit(): bool
    {
        return $this->system_share_percent === null && $this->winner_share_percent === null;
    }

    /**
     * @return array{system_share_percent: int, winner_share_percent: int}
     */
    public function effectiveSplit(): array
    {
        $global = RewardSetting::current();

        return [
            'system_share_percent' => $this->system_share_percent ?? $global->system_share_percent,
            'winner_share_percent' => $this->winner_share_percent ?? $global->winner_share_percent,
        ];
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class);
    }

    public function approvedEntriesForWeek(int $weekNumber)
    {
        return $this->entries()
            ->where('week_number', $weekNumber)
            ->where('status', 'approved')
            ->whereHas('user', fn ($q) => $q->whereNotNull('email_verified_at'));
    }

    public function participantCount(int $weekNumber): int
    {
        return $this->entries()
            ->where('week_number', $weekNumber)
            ->where('status', 'approved')
            ->count();
    }

    public function statusLabel(): string
    {
        return $this->is_active ? 'Open' : 'Closed';
    }
}

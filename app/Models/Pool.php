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
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
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

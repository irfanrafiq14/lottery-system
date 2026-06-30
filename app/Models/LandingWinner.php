<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LandingWinner extends Model
{
    protected $fillable = [
        'name', 'prize_amount', 'country', 'won_at', 'image', 'pool_name', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'won_at' => 'date',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderByDesc('won_at');
    }

    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'http') ? $this->image : Storage::disk('public')->url($this->image);
    }
}

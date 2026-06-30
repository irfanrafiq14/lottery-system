<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LandingTestimonial extends Model
{
    protected $fillable = ['name', 'country', 'review', 'photo', 'rating', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function photoUrl(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        return str_starts_with($this->photo, 'http') ? $this->photo : Storage::disk('public')->url($this->photo);
    }
}

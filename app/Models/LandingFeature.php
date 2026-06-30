<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingFeature extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}

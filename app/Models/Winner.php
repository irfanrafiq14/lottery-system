<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Winner extends Model
{
    protected $fillable = [
        'user_id',
        'pool_id',
        'week_number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class);
    }
}

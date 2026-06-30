<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isEmailVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function emailOtps()
    {
        return $this->hasMany(EmailOtp::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function wins()
    {
        return $this->hasMany(Winner::class);
    }
}

<?php

namespace App\Support;

class NameHelper
{
    public static function publicDisplay(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name)) ?: [];

        if (count($parts) <= 1) {
            return $parts[0] ?? 'Winner';
        }

        $first = $parts[0];
        $lastInitial = strtoupper(substr($parts[count($parts) - 1], 0, 1));

        return "{$first} {$lastInitial}.";
    }
}

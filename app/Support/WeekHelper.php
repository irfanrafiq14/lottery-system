<?php

namespace App\Support;

use Carbon\Carbon;

class WeekHelper
{
    public static function currentWeekNumber(): int
    {
        return self::weekNumberFromDate(Carbon::now());
    }

    public static function weekNumberFromDate(Carbon $date): int
    {
        return (int) ($date->isoWeekYear().str_pad((string) $date->isoWeek(), 2, '0', STR_PAD_LEFT));
    }

    public static function nextDrawAt(): Carbon
    {
        $now = Carbon::now();
        $thisFriday = $now->copy()->startOfWeek()->addDays(4)->startOfDay();

        if ($now->lt($thisFriday)) {
            return $thisFriday;
        }

        return $thisFriday->addWeek();
    }

    public static function lastDrawAt(): Carbon
    {
        return self::nextDrawAt()->subWeek();
    }

    public static function isNewWeekPeriod(): bool
    {
        $now = Carbon::now();

        return $now->gte(self::lastDrawAt()) && $now->lt(self::nextDrawAt());
    }

    public static function formatWeekNumber(int $weekNumber): string
    {
        $year = (int) substr((string) $weekNumber, 0, 4);
        $week = (int) substr((string) $weekNumber, 4);

        return "Week {$week}, {$year}";
    }
}

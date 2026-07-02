<?php

namespace App\Services;

use App\Mail\WeeklyReminderMail;
use App\Mail\WeeklyResetMail;
use App\Mail\WinnerNotificationMail;
use App\Models\Entry;
use App\Models\Pool;
use App\Models\User;
use App\Models\Winner;
use App\Support\WeekHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function __construct(
        private PoolPrizeService $prizeService,
    ) {}

    /**
     * @param  Collection<int, Winner>  $winners
     */
    public function sendWinnerNotifications(Collection $winners): void
    {
        foreach ($winners as $winner) {
            $winner->load(['user', 'pool']);

            $prize = $this->prizeService->prizeForPool($winner->pool, $winner->week_number);

            Mail::to($winner->user->email)->send(
                new WinnerNotificationMail(
                    $winner->user,
                    $winner->pool,
                    $winner->week_number,
                    $winner->prize_amount ?: $prize['winner'],
                    $prize['total'],
                    $prize['participants'],
                )
            );
        }
    }

    /**
     * @param  Collection<int, Winner>  $lastWeekWinners
     */
    public function sendWeeklyResetToAllUsers(Collection $lastWeekWinners, int $completedWeekNumber): int
    {
        $verifiedUsers = User::whereNotNull('email_verified_at')->get();
        $weekLabel = WeekHelper::formatWeekNumber($completedWeekNumber);

        foreach ($verifiedUsers as $user) {
            Mail::to($user->email)->send(
                new WeeklyResetMail($user, $lastWeekWinners, $weekLabel)
            );
        }

        return $verifiedUsers->count();
    }

    public function sendWeeklyReminders(string $type): int
    {
        $weekNumber = WeekHelper::currentWeekNumber();
        $cacheKey = "weekly_reminder_{$type}_{$weekNumber}";

        if (Cache::has($cacheKey)) {
            return 0;
        }

        $nextDraw = WeekHelper::nextDrawAt();
        $weekLabel = WeekHelper::formatWeekNumber($weekNumber);
        $pools = Pool::orderBy('entry_fee')->get();

        $usersWithEntries = Entry::query()
            ->where('week_number', $weekNumber)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('user_id')
            ->unique();

        $verifiedUsers = User::whereNotNull('email_verified_at')->get();
        $sent = 0;

        foreach ($verifiedUsers as $user) {
            $hasEntries = $usersWithEntries->contains($user->id);

            if ($type === 'midweek' && $hasEntries) {
                continue;
            }

            Mail::to($user->email)->send(
                new WeeklyReminderMail(
                    $user,
                    $type,
                    $nextDraw,
                    $weekLabel,
                    $pools,
                    $hasEntries,
                )
            );

            $sent++;
        }

        Cache::put($cacheKey, true, $nextDraw);

        return $sent;
    }
}

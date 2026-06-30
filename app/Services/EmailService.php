<?php

namespace App\Services;

use App\Mail\WeeklyResetMail;
use App\Mail\WinnerNotificationMail;
use App\Models\User;
use App\Models\Winner;
use App\Support\WeekHelper;
use Illuminate\Support\Collection;
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
}

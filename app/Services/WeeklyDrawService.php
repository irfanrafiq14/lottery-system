<?php

namespace App\Services;

use App\Models\Winner;
use App\Support\WeekHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WeeklyDrawService
{
    public function __construct(
        private DrawService $drawService,
        private EmailService $emailService,
        private RealtimeService $realtimeService,
    ) {}

    /**
     * @return array{week_number: int, winners: Collection, deleted_entries: int, reset_emails_sent: int}
     */
    public function execute(?int $weekNumber = null): array
    {
        $weekNumber = $weekNumber ?? WeekHelper::currentWeekNumber();
        $winners = collect();
        $deletedEntries = 0;

        DB::transaction(function () use ($weekNumber, &$winners, &$deletedEntries) {
            $this->drawService->lockAllPools();

            $winners = $this->drawService->selectWinners($weekNumber);

            $deletedEntries = $this->drawService->softDeleteEntriesForWeek($weekNumber);

            $this->drawService->openAllPools();
        });

        $winners = $winners->isNotEmpty()
            ? Winner::with(['user', 'pool'])->whereIn('id', $winners->pluck('id'))->get()
            : $winners;

        if ($winners->isNotEmpty()) {
            $this->emailService->sendWinnerNotifications($winners);
        }

        $resetEmailsSent = $this->emailService->sendWeeklyResetToAllUsers($winners, $weekNumber);

        $result = [
            'week_number' => $weekNumber,
            'winners' => $winners,
            'deleted_entries' => $deletedEntries,
            'reset_emails_sent' => $resetEmailsSent,
        ];

        $this->realtimeService->drawCompleted($result);

        return $result;
    }
}

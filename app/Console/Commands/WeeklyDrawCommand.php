<?php

namespace App\Console\Commands;

use App\Services\WeeklyDrawService;
use App\Support\WeekHelper;
use Illuminate\Console\Command;

class WeeklyDrawCommand extends Command
{
    protected $signature = 'draw:weekly {--week= : Optional week number override (YYYYWW)}';

    protected $description = 'Run weekly draw: select winners, soft-delete entries, reset pools, and send emails';

    public function handle(WeeklyDrawService $weeklyDrawService): int
    {
        $weekNumber = $this->option('week')
            ? (int) $this->option('week')
            : WeekHelper::currentWeekNumber();

        $this->info('Running weekly draw for '.WeekHelper::formatWeekNumber($weekNumber).'...');

        $result = $weeklyDrawService->execute($weekNumber);

        if ($result['winners']->isEmpty()) {
            $this->warn('No winners selected. Entries reset and pools reopened.');
        } else {
            foreach ($result['winners'] as $winner) {
                $winner->load(['user', 'pool']);
                $this->info("Winner: {$winner->user->name} ({$winner->user->email}) — {$winner->pool->name} Pool");
            }
        }

        $this->info("Soft-deleted {$result['deleted_entries']} entries for week {$weekNumber}.");
        $this->info("Sent reset emails to {$result['reset_emails_sent']} verified users.");
        $this->info('Weekly reset complete. Pools are open for new entries.');

        return self::SUCCESS;
    }
}

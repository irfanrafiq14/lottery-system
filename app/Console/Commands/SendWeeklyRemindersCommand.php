<?php

namespace App\Console\Commands;

use App\Services\EmailService;
use Illuminate\Console\Command;

class SendWeeklyRemindersCommand extends Command
{
    protected $signature = 'reminders:weekly {type : midweek or final}';

    protected $description = 'Send weekly draw reminder emails to verified users';

    public function handle(EmailService $emailService): int
    {
        $type = $this->argument('type');

        if (! in_array($type, ['midweek', 'final'], true)) {
            $this->error('Type must be "midweek" or "final".');

            return self::FAILURE;
        }

        $sent = $emailService->sendWeeklyReminders($type);

        $this->info("Sent {$sent} {$type} reminder email(s).");

        return self::SUCCESS;
    }
}

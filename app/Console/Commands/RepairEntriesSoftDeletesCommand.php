<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class RepairEntriesSoftDeletesCommand extends Command
{
    protected $signature = 'entries:repair-soft-deletes';

    protected $description = 'Ensure entries.deleted_at column exists for SoftDeletes support';

    public function handle(): int
    {
        if (Schema::hasColumn('entries', 'deleted_at')) {
            $this->info('entries.deleted_at already exists. No changes needed.');

            return self::SUCCESS;
        }

        Schema::table('entries', function ($table) {
            $table->softDeletes();
        });

        $this->info('Added entries.deleted_at column successfully.');

        return self::SUCCESS;
    }
}

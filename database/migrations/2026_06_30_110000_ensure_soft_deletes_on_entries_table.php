<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('entries', 'deleted_at')) {
            Schema::table('entries', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        Schema::table('entries', function (Blueprint $table) {
            if ($this->indexExists('entries', 'entries_user_id_pool_id_week_number_unique')) {
                if (! $this->indexExists('entries', 'entries_user_id_index')) {
                    $table->index('user_id');
                }
                if (! $this->indexExists('entries', 'entries_pool_id_index')) {
                    $table->index('pool_id');
                }

                $table->dropUnique(['user_id', 'pool_id', 'week_number']);
            }

            if ($this->indexExists('entries', 'entries_transaction_id_unique')) {
                $table->dropUnique(['transaction_id']);
            }

            if (! $this->indexExists('entries', 'entries_user_id_pool_id_week_number_index')) {
                $table->index(['user_id', 'pool_id', 'week_number']);
            }

            if (! $this->indexExists('entries', 'entries_transaction_id_index')) {
                $table->index('transaction_id');
            }
        });
    }

    public function down(): void
    {
        // Intentionally empty — this is a repair migration.
    }

    private function indexExists(string $table, string $index): bool
    {
        foreach (Schema::getIndexes($table) as $definition) {
            if ($definition['name'] === $index) {
                return true;
            }
        }

        return false;
    }
};

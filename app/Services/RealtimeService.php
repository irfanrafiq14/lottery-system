<?php

namespace App\Services;

use App\Events\RealtimeUpdate;
use App\Models\Entry;
use App\Models\Pool;
use App\Models\User;
use App\Models\Winner;
use App\Support\WeekHelper;
use Illuminate\Support\Facades\Log;

class RealtimeService
{
    public function __construct(
        private PoolPrizeService $prizeService,
    ) {}

    public function poolsUpdated(): void
    {
        $this->broadcast('pools.updated', [
            'pools' => $this->poolPayload(),
            'week_number' => WeekHelper::currentWeekNumber(),
        ]);
    }

    public function entryCreated(Entry $entry): void
    {
        $entry->load(['user', 'pool']);

        $this->broadcast('entry.created', [
            'entry' => $this->entryPayload($entry),
            'pools' => $this->poolPayload(),
            'admin_stats' => $this->adminStatsPayload(),
        ], $entry->user_id);
    }

    public function entryStatusChanged(Entry $entry): void
    {
        $entry->load(['user', 'pool']);

        $this->broadcast('entry.status_changed', [
            'entry' => $this->entryPayload($entry),
            'pools' => $this->poolPayload(),
            'admin_stats' => $this->adminStatsPayload(),
        ], $entry->user_id);
    }

    /**
     * @param  array<string, mixed>  $drawResult
     */
    public function drawCompleted(array $drawResult): void
    {
        $winners = collect($drawResult['winners'] ?? [])->map(function (Winner $winner) {
            $winner->load(['user', 'pool']);
            $prize = $this->prizeService->prizeForPool($winner->pool, $winner->week_number);

            return [
                'user_name' => $winner->user->name,
                'pool_name' => $winner->pool->name,
                'week_number' => $winner->week_number,
                'winner_prize' => $winner->prize_amount ?: $prize['winner'],
            ];
        });

        $this->broadcast('draw.completed', [
            'winners' => $winners,
            'pools' => $this->poolPayload(),
            'admin_stats' => $this->adminStatsPayload(),
            'week_number' => $drawResult['week_number'] ?? WeekHelper::currentWeekNumber(),
            'deleted_entries' => $drawResult['deleted_entries'] ?? 0,
            'next_draw_at' => WeekHelper::nextDrawAt()->toIso8601String(),
        ]);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function broadcast(string $action, array $payload, ?int $userId = null): void
    {
        if (config('broadcasting.default') === 'null' || config('broadcasting.default') === 'log') {
            return;
        }

        try {
            RealtimeUpdate::dispatch($action, $payload, $userId);
        } catch (\Throwable $e) {
            Log::warning('Realtime broadcast skipped — Reverb may not be running.', [
                'action' => $action,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function poolPayload(): array
    {
        $weekNumber = WeekHelper::currentWeekNumber();

        return Pool::orderBy('entry_fee')->get()->map(function (Pool $pool) use ($weekNumber) {
            $prize = $this->prizeService->prizePayload($pool, $weekNumber);

            return array_merge([
                'id' => $pool->id,
                'name' => $pool->name,
                'slug' => $pool->slug,
                'entry_fee' => $pool->entry_fee,
                'is_active' => $pool->is_active,
                'status_label' => $pool->statusLabel(),
                'participants' => $prize['participants'],
            ], $prize);
        })->values()->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function entryPayload(Entry $entry): array
    {
        return [
            'id' => $entry->id,
            'user_id' => $entry->user_id,
            'user_name' => $entry->user->name,
            'user_email' => $entry->user->email,
            'pool_id' => $entry->pool_id,
            'pool_name' => $entry->pool->name,
            'transaction_id' => $entry->transaction_id,
            'status' => $entry->status,
            'week_number' => $entry->week_number,
            'created_at' => $entry->created_at?->format('M d, Y H:i'),
        ];
    }

    /**
     * @return array<string, int>
     */
    private function adminStatsPayload(): array
    {
        return [
            'users' => User::count(),
            'pending_entries' => Entry::where('status', 'pending')->count(),
            'approved_entries' => Entry::where('status', 'approved')->count(),
            'winners' => Winner::count(),
        ];
    }
}

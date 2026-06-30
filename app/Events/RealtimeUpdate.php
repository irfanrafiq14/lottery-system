<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        public string $action,
        public array $payload = [],
        public ?int $userId = null,
    ) {}

    /**
     * @return array<int, Channel|PrivateChannel>
     */
    public function broadcastOn(): array
    {
        $channels = [
            new Channel('pools'),
            new PrivateChannel('admin.dashboard'),
        ];

        if ($this->userId) {
            $channels[] = new PrivateChannel('user.'.$this->userId);
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'realtime.update';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'payload' => $this->payload,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}

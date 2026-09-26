<?php

namespace App\Jobs;

use App\Notifications\NotificationDispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $channel,
        public readonly array $payload
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        NotificationDispatcher $dispatcher,
    ): void {
        $dispatcher->dispatch(
            $this->channel,
            $this->payload
        );
    }
}

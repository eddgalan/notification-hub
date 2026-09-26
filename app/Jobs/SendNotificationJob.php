<?php

namespace App\Jobs;

use App\Notifications\NotificationDispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Maximum number of attempts.
     *
     * @var int $tries
     */
    public int $tries = 4;

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

    /**
     * Determine the backoff time intervals for the job.
     *
     * @return array
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }
}

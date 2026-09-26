<?php

namespace App\Jobs;

use App\Exceptions\Notifications\NonRetryableNotificationException;
use App\Notifications\NotificationDispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Maximum number of attempts.
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
        try {
            $dispatcher->dispatch(
                $this->channel,
                $this->payload
            );
        } catch (NonRetryableNotificationException $e) {
            $this->fail($e);
        }
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

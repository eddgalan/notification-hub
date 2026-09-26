<?php

namespace App\Jobs;

use App\Notifications\NotificationDispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var array $channels
     */
    private array $channels;

    /**
     * @var array $payload
     */
    private array $payload;

    /**
     * Create a new job instance.
     */
    public function __construct(
        array $channels,
        array $payload
    ) {
        $this->channels = $channels;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(
        NotificationDispatcher $dispatcher,
    ): void {
        $dispatcher->dispatch(
            $this->channels,
            $this->payload
        );
    }
}

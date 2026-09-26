<?php

namespace App\Notifications;

use App\Notifications\Contracts\NotificationChannel;
use InvalidArgumentException;

class NotificationChannelPool
{
    /**
     * @var array $channels
     */
    private array $channels;

    /**
     * @param array $channels
     */
    public function __construct(
        array $channels = []
    ) {
        $this->channels = $channels;
    }

    /**
     * Retrieves the specified notification channel.
     *
     * @throws InvalidArgumentException
     */
    public function get(string $channel): NotificationChannel
    {
        if (! isset($this->channels[$channel])) {
            throw new InvalidArgumentException(
                "Unsupported notification channel: {$channel}"
            );
        }

        return $this->channels[$channel];
    }
}

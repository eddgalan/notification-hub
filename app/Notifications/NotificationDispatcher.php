<?php

namespace App\Notifications;

class NotificationDispatcher
{
    /**
     * @var NotificationChannelPool $channelPool
     */
    private NotificationChannelPool $channelPool;

    /**
     * @param NotificationChannelPool $channelPool
     */
    public function __construct(
        NotificationChannelPool $channelPool
    ) {
        $this->channelPool = $channelPool;
    }

    /**
     * Sends a payload to a list of specified channels.
     */
    public function dispatch(array $channels, array $payload): void
    {
        foreach ($channels as $channelName) {
            $channel = $this->channelPool->get($channelName);

            $channel->send($payload);
        }
    }
}

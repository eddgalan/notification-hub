<?php

namespace App\Notifications;

readonly class NotificationDispatcher
{
    /**
     * @param NotificationChannelPool $channelPool
     */
    public function __construct(
        private NotificationChannelPool $channelPool
    ) {}

    /**
     * Dispatches a payload to the specified channel.
     *
     * @param string $channelName
     * @param array $payload
     * @return void
     */
    public function dispatch(string $channelName, array $payload): void
    {
        $channel = $this->channelPool->get($channelName);

        $channel->send($payload);
    }
}

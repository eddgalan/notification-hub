<?php

namespace Tests\Unit;

use App\Notifications\Contracts\NotificationChannel;
use App\Notifications\NotificationChannelPool;
use App\Notifications\NotificationDispatcher;
use Tests\TestCase;

class NotificationDispatcherTest extends TestCase
{
    public function test_invokes_send_on_the_resolved_channel(): void
    {
        $channel = new class implements NotificationChannel
        {
            public bool $sent = false;

            public array $sentPayload = [];

            public function send(array $payload): void
            {
                $this->sent = true;
                $this->sentPayload = $payload;
            }
        };
        $dispatcher = new NotificationDispatcher(new NotificationChannelPool([
            'email' => $channel,
        ]));
        $payload = [
            'user_id' => 1,
            'email' => 'dev@example.com',
            'message' => 'Bienvenido a Notification Hub',
        ];

        $dispatcher->dispatch('email', $payload);

        $this->assertTrue($channel->sent);
        $this->assertSame($payload, $channel->sentPayload);
    }
}

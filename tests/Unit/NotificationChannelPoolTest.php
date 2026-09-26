<?php

namespace Tests\Unit;

use App\Notifications\Contracts\NotificationChannel;
use App\Notifications\NotificationChannelPool;
use InvalidArgumentException;
use Tests\TestCase;

class NotificationChannelPoolTest extends TestCase
{
    public function test_returns_the_registered_channel(): void
    {
        $channel = new class implements NotificationChannel
        {
            public function send(array $payload): void {}
        };
        $pool = new NotificationChannelPool([
            'email' => $channel,
        ]);

        $this->assertSame($channel, $pool->get('email'));
    }

    public function test_rejects_an_unsupported_channel(): void
    {
        $pool = new NotificationChannelPool;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported notification channel: sms');

        $pool->get('sms');
    }
}

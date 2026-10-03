<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\Notifications\Contracts\NotificationChannel;
use Illuminate\Support\Facades\Log;

class SmsNotificationChannel implements NotificationChannel
{
    /**
     * @param array $payload
     * @return void
     */
    public function send(array $payload): void
    {
        Log::info('SMS notification sent', [
            'message' => $payload['message'] ?? null,
            'payload' => $payload,
        ]);
    }
}

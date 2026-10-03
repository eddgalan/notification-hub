<?php

declare(strict_types=1);

namespace App\Notifications\Channels;

use App\Exceptions\Notifications\NonExistentRecipientEmailException;
use App\Notifications\Contracts\NotificationChannel;
use Illuminate\Support\Facades\Log;

class EmailNotificationChannel implements NotificationChannel
{
    /**
     * Sends an email notification and logs the relevant information.
     */
    public function send(array $payload): void
    {
        $recipient = $payload['email'];

        if ($recipient === 'not.exists@email.com') {
            throw NonExistentRecipientEmailException::forEmail($recipient);
        }

        Log::info('Email notification sent', [
            'recipient' => $payload['email'] ?? null,
            'message' => $payload['message'] ?? null,
            'payload' => $payload,
        ]);
    }
}

<?php

namespace App\Exceptions\Notifications;

class NonExistentRecipientEmailException extends NonRetryableNotificationException
{
    public static function forEmail(string $email): self
    {
        return new self("Recipient email does not exist: {$email}");
    }
}

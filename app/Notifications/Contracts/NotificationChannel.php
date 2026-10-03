<?php

namespace App\Notifications\Contracts;

interface NotificationChannel
{
    public function send(array $payload): void;
}

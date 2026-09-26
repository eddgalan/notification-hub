<?php

namespace App\Providers;

use App\Notifications\Channels\EmailNotificationChannel;
use App\Notifications\Channels\TelegramNotificationChannel;
use App\Notifications\NotificationChannelPool;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NotificationChannelPool::class, function ($app) {
            return new NotificationChannelPool([
                'email' => $app->make(EmailNotificationChannel::class),
                'telegram' => $app->make(TelegramNotificationChannel::class),
            ]);
        });
    }
}

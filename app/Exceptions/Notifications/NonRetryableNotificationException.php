<?php

namespace App\Exceptions\Notifications;

use Illuminate\Contracts\Debug\ShouldntReport;
use RuntimeException;

class NonRetryableNotificationException extends RuntimeException implements ShouldntReport
{
    //
}

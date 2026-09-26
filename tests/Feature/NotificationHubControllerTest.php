<?php

namespace Tests\Feature;

use App\Jobs\SendNotificationJob;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationHubControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_payload_queues_a_notification_job_for_each_channel(): void
    {
        $user = User::factory()->create();
        Queue::fake([SendNotificationJob::class]);
        Sanctum::actingAs($user);

        $response = $this->postJson(route('v1.notifications.dispatch'), [
            'channels' => ['email', 'telegram'],
            'payload' => [
                'user_id' => $user->id,
                'email' => 'dev@example.com',
                'message' => 'Bienvenido a Notification Hub',
            ],
        ]);

        $response->assertAccepted()
            ->assertJson([
                'message' => 'Notification accepted',
            ]);

        Queue::assertPushed(SendNotificationJob::class, 2);
        Queue::assertPushed(
            SendNotificationJob::class,
            fn (SendNotificationJob $job): bool => $job->channel === 'email'
                && $job->payload['email'] === 'dev@example.com'
                && $job->payload['message'] === 'Bienvenido a Notification Hub'
        );
        Queue::assertPushed(
            SendNotificationJob::class,
            fn (SendNotificationJob $job): bool => $job->channel === 'telegram'
                && $job->payload['user_id'] === $user->id
        );
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\DispatchNotificationRequest;
use App\Notifications\NotificationDispatcher;
use Illuminate\Http\JsonResponse;

class NotificationHubController extends Controller
{
    /**
     * @var NotificationDispatcher
     */
    private NotificationDispatcher $dispatcher;

    /**
     * @param NotificationDispatcher $dispatcher
     */
    public function __construct(
        NotificationDispatcher $dispatcher
    ) {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param DispatchNotificationRequest $request
     * @return JsonResponse
     */
    public function dispatch(DispatchNotificationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->dispatcher->dispatch(
            $data['channels'],
            $data['payload']
        );

        return response()->json([
            'message' => 'Notification accepted',
        ], 202);
    }
}

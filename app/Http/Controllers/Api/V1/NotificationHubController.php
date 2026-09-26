<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\DispatchNotificationRequest;
use App\Jobs\SendNotificationJob;
use Illuminate\Http\JsonResponse;

class NotificationHubController extends Controller
{
    /**
     * @param DispatchNotificationRequest $request
     * @return JsonResponse
     */
    public function dispatch(DispatchNotificationRequest $request): JsonResponse
    {
        $data = $request->validated();

        SendNotificationJob::dispatch(
            $data['channels'],
            $data['payload'],
        );

        return response()->json([
            'message' => 'Notification accepted',
        ], 202);
    }
}

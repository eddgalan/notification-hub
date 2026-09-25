<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationHubController extends Controller
{
    public function dispatch(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Ok'
        ], '200');
    }
}

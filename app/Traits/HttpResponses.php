<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    public function successResponse($message, $data = null, $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function errorResponse($message, $status = 400): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], $status);
    }
}

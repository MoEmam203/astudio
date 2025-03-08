<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('successResponse')) {
    function successResponse($data = [], $message = null, $code = 200): JsonResponse
    {
        return response()->json(data: [
            'status' => 1,
            'message' => $message,
            'data' => $data,
        ], status: $code);
    }
}

if (! function_exists('failureResponse')) {
    function failureResponse($message = null, $code = 403): JsonResponse
    {
        return response()->json(data: [
            'status' => 0,
            'message' => $message,
            'data' => null,
        ], status: $code);
    }
}

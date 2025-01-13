<?php

namespace App\Http\Controllers\Api\V1\Traits;

use Illuminate\Http\JsonResponse;

trait ExceptionResponse
{
    public function exceptionMessage($exception): JsonResponse
    {
        return response()->json(['errors' => "message: {$exception->getMessage()},
        line: {$exception->getLine()}, file: {$exception->getFile()}"], 500);
    }

    public function responseMessage($status, $message = 'success', $code = 200, $data = []): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}

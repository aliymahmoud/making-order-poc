<?php
namespace App\Support\Handler;

use Illuminate\Http\JsonResponse;

abstract class BaseHandler implements HandlerInterface
{
    
    protected function success($data = null, $message = null, $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function error($message = null, $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $status);
    }
}
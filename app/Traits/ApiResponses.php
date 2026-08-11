<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function success(string $message, ?array $data = null, int $statusCode = 200)
    {
        return response()->json(['message' => $message, 'data' => $data, 'status' => $statusCode], $statusCode);
    }

    protected function error(string $message, int $statusCode)
    {
        return response()->json(['message' => $message, 'status' => $statusCode], $statusCode);
    }

    //    protected function error(?array $errors, int $statusCode) : JsonResponse
    //    {
    //        if (is_string($errors)) {
    //            return response()->json(['message' => $errors, 'status' => $statusCode], $statusCode);
    //
    //        }
    //
    //        return response()->json(['errors' => $errors, 'status' => $statusCode], $statusCode);
    //    }

    protected function ok(string $message, ?array $data = null)
    {
        return $this->success($message, $data);
    }
}

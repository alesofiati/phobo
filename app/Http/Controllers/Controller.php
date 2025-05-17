<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function errorResponse(string $message, int $statusCode = 200, array $details = [])
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'details' => $details,
            ],
        ], $statusCode);
    }
}

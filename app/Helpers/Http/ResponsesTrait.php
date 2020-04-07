<?php

namespace App\Helpers\Http;

trait ResponsesTrait
{
    public function success($data, $append = [])
    {
        return response()->json(array_merge([
            'data' => $data,
            'success' => true
        ], $append));
    }

    public function error($message)
    {
        return response()->json([
            'error' => $message,
            'success' => false
        ]);
    }
}

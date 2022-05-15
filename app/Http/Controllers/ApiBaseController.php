<?php

namespace App\Http\Controllers;

class ApiBaseController extends Controller
{
    public function response(bool $success = true, int $status = 200, array $data = [], array $meta = [], $message = '')
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
            'meta'    => $meta
        ], $status);
    }
}

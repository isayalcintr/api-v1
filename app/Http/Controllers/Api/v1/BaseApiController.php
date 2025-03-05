<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    protected function successResponse($message = "Success", $data = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function errorResponse($message = "Error", $errors = null, $status = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'errors'  => $errors
        ], $status);
    }
}

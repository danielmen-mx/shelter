<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function responseWithData($data, $message, $statusCode = 200)
    {
        $response = (object) [
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    public function responseWithError($exception, $message)
    {        
        $response = (object) [
            'message' => $message,
            'exception' => $exception ? $exception->getMessage() : null,
        ];

        $code = $exception ? $exception->getCode() : 417;

        return response()->json($response, $code);
    }

    public function responseWithMessage($message, $statusCode = 200)
    {
        return $this->responseWithData(null, $message, $statusCode);
    }
}
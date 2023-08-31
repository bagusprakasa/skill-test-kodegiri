<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class Helpers
{
    protected static $response = [
        'meta' => [
            'code' => Response::HTTP_OK,
            'status' => 'success',
            'message' => null
        ],
        'data' => null,
    ];

    public static function succesResponse($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function errorResponse($data = null, $message = null, $code)
    {
        self::$response['meta']['message'] = $message;
        self::$response['meta']['code'] = $code;
        self::$response['meta']['status'] = 'error';
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}

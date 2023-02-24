<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;

class GeneralError
{
    public static function make($data)
    {
        $code = isset($data['code']) ? $data['code'] : 500;

        return new JsonResponse([
            'status' => false,
            'code' => $code,
            'message' => $data['message'],
            'error' => isset($data['error']) ? $data['error'] : array()
        ],$code);
    }
}

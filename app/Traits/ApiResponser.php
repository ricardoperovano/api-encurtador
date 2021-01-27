<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * @param string|array $data
     * @param string $code
     * @return Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(
            $data,
            $code
        );
    }

    /**
     * @param string $message
     * @param string $code
     * @return Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code = 422)
    {
        return response()->json(
            [
                'error' => $message,
                'code'  => $code
            ],
            $code
        );
    }
}

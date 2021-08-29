<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class APIController extends Controller
{
    /**
     * Respond OK (20x code)
     *
     * @param mixed $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function respondOk($data = [], int $statusCode = 200): JsonResponse
    {
        return $this->respond($data, $statusCode);
    }

    /**
     * Respond NOT OK (40x code)
     *
     * @param mixed $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function respondNotOk($data = [], int $statusCode = 400): JsonResponse
    {
        return $this->respond($data, $statusCode);
    }

    private function respond($data, int $statusCode): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }
}

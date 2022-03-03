<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Trait ApiResponder
 * @package App\Traits
 */
trait ApiResponder
{
    /**
     * @var array|int[]
     */
    private array $successCodes = [200, 201, 204];

    /**
     * @param string $message
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function respond(string $message, $data = [], int $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => in_array($code, $this->successCodes),
            'message' => $message,
            'data' => $data,
        ], $code);
    }

}

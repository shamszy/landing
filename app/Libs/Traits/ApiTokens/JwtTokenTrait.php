<?php

namespace App\Libs\Traits\ApiTokens;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * JwtTokenTrait
 */
trait JwtTokenTrait
{

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @param $loggedInUser
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, $loggedInUser): JsonResponse
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => new UserResource($loggedInUser),
            'success' => true
        ], Response::HTTP_OK);
    }

}

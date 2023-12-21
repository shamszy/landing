<?php

namespace App\Libs\Traits\ApiTokens;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait SanctumTokenTrait
{
    /**
     * Get the token array structure.
     *
     * @param $loggedInUser
     * @return JsonResponse
     */
    protected function respondWithToken($loggedInUser): JsonResponse
    {
        $token = $loggedInUser->createToken('apiToken')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => new UserResource(auth()->user()),
            'token_type' => 'bearer',
            'success' => true
        ], Response::HTTP_OK);
    }

}

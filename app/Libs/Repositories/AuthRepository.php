<?php

namespace App\Libs\Repositories;

use App\Http\Resources\UserResource;
use App\Libs\Helpers\ActivityLogHelper;
use App\Libs\Traits\ApiTokens\JwtTokenTrait;
use App\Libs\Traits\AuthUserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Libs\Repositories\Contracts\AuthRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

readonly class AuthRepository implements AuthRepositoryInterface
{
    use AuthUserTrait, JwtTokenTrait;

    /**
     * @param ActivityLogHelper $activityLogHelper
     */
    public function __construct(private ActivityLogHelper $activityLogHelper )
    {}

    /**
     * Get a JWT via given credentials.
     *
     * @param $request
     * @return JsonResponse
    */
    public function login($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid login details',
                    'success' => false
                ], Response::HTTP_UNAUTHORIZED);
            } elseif($this->getAuthUser()->email_verified_at == NULL) {
                return response()->json([
                    'message' => 'Email must be verified',
                    'success' => false
                ], Response::HTTP_UNAUTHORIZED);
            }elseif ($this->getAuthUser()->account_status != 'ACTIVE') {
                return response()->json([
                    'message' => 'Sorry your account is not active kindly contact '. strtolower(config('app.name')),
                    'success' => false
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $this->activityLogHelper->log($this->getAuthUser()->id, 'Login', 'User logged in', 'Successful'); //create activity log
                return $this->respondWithToken($token, $this->getAuthUser());
            }
        }
    }

    /**
     * logout authenticated user
     * @return JsonResponse
    */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json([
            'message' => 'Logged out successfully',
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * users profile
     * @return UserResource
    */
    public function userProfile(): UserResource
    {
        return (new UserResource($this->getAuthUser()))->additional( [
            'message' => "Users profile fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
    */
    public function refresh(): JsonResponse
    {
        $newToken = auth()->refresh(true, true);
        return $this->respondWithToken($newToken, $this->getAuthUser());
    }

}


<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\AuthRepositoryInterface;

class AuthController extends Controller
{

    /**
     * @param AuthRepositoryInterface $repository
     */
    public function __construct(private readonly AuthRepositoryInterface $repository)
    {}

    /**
     * login
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request): mixed
    {
        return $this->repository->login($request);
    }

    /**
     * logout
     * @return mixed
     */
    public function logout(): mixed
    {
        return $this->repository->logout();
    }

    /**
     * user profile
     * @return mixed
     */
    public function userProfile(): mixed
    {
        return $this->repository->userProfile();
    }

    /**
     * refresh auth token
     * @return mixed
     */
    public function refreshAuthToken(): mixed
    {
        return $this->repository->refresh();
    }

}

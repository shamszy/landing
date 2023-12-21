<?php

namespace App\Libs\Repositories\Contracts;

/**
 * AuthRepositoryInterface
 */
interface AuthRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function login($request): mixed;

    /**
     * @return mixed
     */
    public function logout(): mixed;

    /**
     * @return mixed
     */
    public function userProfile(): mixed;

    /**
     * @return mixed
     */
    public function refresh(): mixed;
}

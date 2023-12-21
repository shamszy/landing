<?php

namespace App\Libs\Repositories\Contracts;

/**
 * ForgotPasswordRepositoryInterface
 */
interface ForgotPasswordRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function sendPasswordResetLink($request): mixed;

    /**
     * @param $request
     * @return mixed
     */
    public function resetPassword($request): mixed;
}

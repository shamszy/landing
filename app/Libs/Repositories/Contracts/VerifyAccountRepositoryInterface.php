<?php

namespace App\Libs\Repositories\Contracts;

/**
 * VerifyAccountRepositoryInterface
 */
interface VerifyAccountRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function verifyAccount($request): mixed;

    /**
     * @param $request
     * @return mixed
     */
    public function reSendOtp($request): mixed;
}

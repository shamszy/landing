<?php

namespace App\Libs\Repositories\Contracts;

/**
 * Settings repository interface
 */
interface SettingsRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function changeAccountPassword($request): mixed;

    /**
     * @param $request
     * @return mixed
     */
    public function suspendAndActivateUserAccount($request): mixed;

    /**
     * @param $request
     * @return mixed
     */
    public function uploadImage($request): mixed;

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\SettingsRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Settings controller
 */
class SettingsController extends Controller
{

    /**
     * @param SettingsRepositoryInterface $repository
     */
    public function __construct(private readonly SettingsRepositoryInterface $repository)
    {}
    /**
     * chance account password
     * @param Request $request
     * @return mixed
     */
    public function changePasswordMethod(Request $request): mixed
    {
        return $this->repository->changeAccountPassword($request);
    }

    /**
     * suspend and activate account
     * @param Request $request
     * @return mixed
     */
    public function suspendAndActivateUserAccountMethod(Request $request): mixed
    {
        return $this->repository->suspendAndActivateUserAccount($request);
    }

    /**
     * upload profile image
     * @param Request $request
     * @return mixed
     */
    public function uploadImageMethod(Request $request): mixed
    {
        return $this->repository->uploadImage($request);
    }

}

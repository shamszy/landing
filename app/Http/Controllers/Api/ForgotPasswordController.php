<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\Repositories\Contracts\ForgotPasswordRepositoryInterface;

class ForgotPasswordController extends Controller
{

    /**
     * @param ForgotPasswordRepositoryInterface $repository
     */
    public function __construct(private readonly  ForgotPasswordRepositoryInterface $repository)
    {}

    /**
     * send forgot password link
     * @param Request $request
     * @return mixed
     */
    public function send(Request $request): mixed
    {
        return $this->repository->sendPasswordResetLink($request);
    }

    /**
     * reset forgot password
     * @param Request $request
     * @return mixed
     */
    public function reset(Request $request): mixed
    {
        return $this->repository->resetPassword($request);
    }

}

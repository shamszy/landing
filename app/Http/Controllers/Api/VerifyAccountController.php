<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Libs\Enums\AccountTierEnum;
use App\Libs\Repositories\Contracts\VerifyAccountRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libs\Helpers\WalletHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verify account
 */
class VerifyAccountController extends Controller
{

    /**
     * @param VerifyAccountRepositoryInterface $repository
     */
    public function __construct(private readonly VerifyAccountRepositoryInterface $repository)
    {}

    /**
     * @param Request $request
     * @return mixed
     */
    public function verifyMethod(Request $request): mixed
    {
        return $this->repository->verifyAccount($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function reSendOtpMethod(Request $request): mixed
    {
        return $this->repository->reSendOtp($request);
    }

}

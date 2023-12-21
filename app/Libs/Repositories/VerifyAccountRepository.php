<?php

namespace App\Libs\Repositories;

use App\Exceptions\DatabaseException;
use App\Libs\Actions\VerifyAccountAction;
use App\Libs\Repositories\Contracts\VerifyAccountRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

/**
 * VerifyAccountRepository
 */
readonly class VerifyAccountRepository implements VerifyAccountRepositoryInterface
{
    /**
     * @param VerifyAccountAction $action
     */
    public function __construct(private VerifyAccountAction $action)
    {}

    /**
     * verify account
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function verifyAccount($request): JsonResponse
    {
        $validator =  Validator::make($request->all(), [
            'otpCode' => 'required',
            'type' => 'required',
            'withdrawalId' => Rule::when($request->type === 'transaction' , ['required'])
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return  $this->action->verifyAccountAction($request);
        }
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function reSendOtp($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            return $this->action->reSendOtpAction($request);
        }
    }

}

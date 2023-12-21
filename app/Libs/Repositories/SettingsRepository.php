<?php

namespace App\Libs\Repositories;

use App\Exceptions\DatabaseException;
use App\Libs\Actions\SettingsAction;
use App\Libs\Repositories\Contracts\SettingsRepositoryInterface;
use App\Libs\Traits\SystemValidatorTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

/**
 * Settings repository
 */
readonly class SettingsRepository implements SettingsRepositoryInterface
{
    use SystemValidatorTrait;

    /**
     * @param SettingsAction $action
     */
    public function __construct(private SettingsAction $action)
    {}

    /**
     * change account password
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function changeAccountPassword($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => ['required','confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->changeAccountPasswordAction($request);
        }
    }

    /**
     * suspend user account
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function suspendAndActivateUserAccount($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'status' => ['required', 'in:'. $this->validatorInArray(['active', 'suspended'])->implode(',')],
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->suspendAndActivateUserAccountAction($request);
        }
    }

    /**
     * upload customer
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function uploadImage($request): JsonResponse
    {
        $validator =  Validator::make($request->all(),[
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return  $this->action->uploadImageAction($request);
        }
    }

}

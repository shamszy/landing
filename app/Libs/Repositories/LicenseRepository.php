<?php

namespace App\Libs\Repositories;

use App\Exceptions\DatabaseException;
use App\Http\Resources\LicenseResource;
use App\Libs\Actions\LicenseAction;
use App\Libs\Repositories\Contracts\LicenseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * LicenseRepository
 */
readonly class LicenseRepository implements LicenseRepositoryInterface
{
    /**
     * @param LicenseAction $action
     */
    public function __construct(private LicenseAction $action)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function addLicense($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'license' => 'required',
            'issuedDate' => 'required',
            'expiryDate' => 'required',
            'paymentProve' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->addLicenseAction($request);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllLicenses(): AnonymousResourceCollection
    {
        return $this->action->getAllLicensesAction();
    }

    /**
     * @param $slug
     * @return LicenseResource
     */
    public function getSingleLicense($slug): LicenseResource
    {
        return $this->action->getSingleLicenseAction($slug);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateLicense($request, $slug): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'paymentProve' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->updateLicenseAction($request, $slug);
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteLicense($slug): JsonResponse
    {
        return $this->action->deleteLicenseAction($slug);
    }

}

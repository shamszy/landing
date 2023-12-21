<?php

namespace App\Libs\Actions;

use App\Exceptions\DatabaseException;
use App\Http\Resources\LicenseResource;
use App\Libs\Services\AwsService;
use App\Libs\Traits\AuthUserTrait;
use App\Models\License;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * LicenseAction
 */
readonly class LicenseAction
{
    use AuthUserTrait;

    /**
     * @param License $model
     * @param AwsService $awsService
     */
    public function __construct(private License $model, private AwsService $awsService)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function addLicenseAction($request): JsonResponse
    {
        try {
            $license = $this->model->create([
                'company_id' => $this->getAuthUser()->company->id,
                'title' => $request->title. ' For '. $this->getAuthUser()->company->name,
                'license_link' => $this->awsService->pushFileToAwsS3BucketService($request, 'license'),
                'issued_date' => $request->issuedDate,
                'expiry_date' => $request->expiryDate,
                'previous_payment_prove' => $request->paymentProve
            ]);
            return response()->json([
                'message' => "License added successfully",
                'data' => new LicenseResource($license),
                'success' => true
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            throw new DatabaseException("Sorry unable to add license", $e->getMessage());
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllLicensesAction(): AnonymousResourceCollection
    {
        if ($this->getAuthUser()->role == 'company') {
            $licenses = $this->model->where('company_id', '=', $this->getAuthUser()->company->id)->latest()->paginate(10);
        } else {
            $licenses = $this->model->latest()->paginate(10);
        }
        return LicenseResource::collection($licenses)->additional([
            'message' => "All license fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return LicenseResource
     */
    public function getSingleLicenseAction($slug): LicenseResource
    {
        $license = $this->model->whereSlug($slug)->firstOrFail();
        return (new LicenseResource($license))->additional( [
            'message' => "License details fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateLicenseAction($request, $slug): JsonResponse
    {
        $license = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $license->update([
                'previous_payment_prove' => empty($request->paymentProve) ? $license->previous_payment_prove : $request->paymentProve
            ]);
            return response()->json([
                'message' => "License updated successfully",
                'data' => new LicenseResource($license),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new DatabaseException("Sorry unable to update license", $e->getMessage());
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteLicenseAction($slug): JsonResponse
    {
        $license = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $license->delete();
            return response()->json([
                'message' => 'License deleted successfully',
                'data' => new LicenseResource($license),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to delete license", $e->getMessage());
        }
    }

}

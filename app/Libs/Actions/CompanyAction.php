<?php

namespace App\Libs\Actions;

use App\Exceptions\DatabaseException;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Libs\Enums\RoleEnum;
use App\Libs\Helpers\SystemHelper;
use App\Libs\Traits\SentOtpTrait;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * CompanyAction
 */
readonly class CompanyAction
{
    use SentOtpTrait;

    /**
     * @param Company $model
     * @param User $userModel
     * @param SystemHelper $systemHelper
     */
    public function __construct(private Company $model, private User $userModel, private SystemHelper $systemHelper)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function createCompanyAction($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $this->userModel->create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => RoleEnum::COMPANY
            ]);
            $user->company()->create([
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phoneNumber,
                'cac_number'  => $request->cacNumber
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            throw new DatabaseException("Sorry unable to create company account", $e->getMessage());
        }
        DB::commit();
        $this->sendOtp($user->id, $this->systemHelper->generateRandomCode(6),$request->name, $request->email, 'verification');
        return response()->json([
            'message' => "Company account created successfully",
            'data' => new UserResource($user),
            'success' => true
        ], Response::HTTP_CREATED);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllCompaniesAction(): AnonymousResourceCollection
    {
        $companies = $this->model->latest()->paginate(10);
        return CompanyResource::collection($companies)->additional([
            'message' => "All companies fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return CompanyResource
     */
    public function getSingleCompanyAction($slug): CompanyResource
    {
        $company = $this->model->whereSlug($slug)->firstOrFail();
        return (new CompanyResource($company))->additional( [
            'message' => "Company details fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateCompanyAction($request, $slug): JsonResponse
    {
        $company = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $company->update([
                'name' => empty($request->name) ? $company->name : $request->name,
                'address' => empty($request->address) ? $company->address : $request->address,
                'phone_number' => empty($request->phoneNumber) ? $company->phone_number : $request->phoneNumber,
                'cac_number'  =>  empty($request->cacNumber) ? $company->cac_number : $request->cacNumber
            ]);
            return response()->json([
                'message' => "Company profile updated successfully",
                'data' => new CompanyResource($company),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to update company", $e->getMessage());
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteCompanyAction($slug): JsonResponse
    {
        $company = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $company->delete();
            return response()->json([
                'message' => 'Company deleted successfully',
                'data' => new CompanyResource($company),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to delete company", $e->getMessage());
        }
    }

}

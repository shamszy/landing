<?php

namespace App\Libs\Repositories;

use App\Exceptions\DatabaseException;
use App\Http\Resources\CompanyResource;
use App\Libs\Actions\CompanyAction;
use App\Libs\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * CompanyRepository
 */
readonly class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param CompanyAction $action
     */
    public function __construct(private CompanyAction $action)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function createCompany($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phoneNumber' => 'required',
            'cacNumber' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->createCompanyAction($request);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllCompanies(): AnonymousResourceCollection
    {
        return $this->action->getAllCompaniesAction();
    }

    /**
     * @param $slug
     * @return CompanyResource
     */
    public function getSingleCompany($slug): CompanyResource
    {
        return $this->action->getSingleCompanyAction($slug);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateCompany($request, $slug): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'address' => 'sometimes',
            'phoneNumber' => 'sometimes',
            'cacNumber' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->updateCompanyAction($request, $slug);
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteCompany($slug): JsonResponse
    {
        return $this->action->deleteCompanyAction($slug);
    }

}

<?php

namespace App\Libs\Repositories;

use App\Exceptions\DatabaseException;
use App\Http\Resources\CategoryResource;
use App\Libs\Actions\CategoryAction;
use App\Libs\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * CategoryRepository
 */
readonly class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @param CategoryAction $action
     */
    public function __construct(private CategoryAction $action )
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function createCategory($request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'annualPayment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->createCategoryAction($request);
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllCategories(): AnonymousResourceCollection
    {
        return $this->action->getAllCategoriesAction();
    }

    /**
     * @param $slug
     * @return CategoryResource
     */
    public function getSingleCategory($slug): CategoryResource
    {
        return $this->action->getSingleCategoryAction($slug);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateCategory($request, $slug): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'description' => 'sometimes',
            'annualPayment' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else {
            return $this->action->updateCategoryAction($request, $slug);
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteCategory($slug): JsonResponse
    {
        return $this->action->deleteCategoryAction($slug);
    }

}

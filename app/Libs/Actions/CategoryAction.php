<?php

namespace App\Libs\Actions;

use App\Exceptions\DatabaseException;
use App\Http\Resources\CategoryResource;
use App\Libs\Helpers\SystemHelper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * CategoryAction
 */
readonly class CategoryAction
{
    /**
     * @param Category $model
     * @param SystemHelper $systemHelper
     */
    public function __construct(private Category $model, private SystemHelper $systemHelper)
    {}

    /**
     * @param $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function createCategoryAction($request): JsonResponse
    {
        try {
            $category = $this->model->create([
                'name' => $request->name,
                'description' => $request->description,
                'annual_payment' => $this->systemHelper->convertToKobo($request->annualPayment)
            ]);
            return response()->json([
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category),
                'success' => true
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to create category",  $e->getMessage());
        }
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllCategoriesAction(): AnonymousResourceCollection
    {
        $categories = $this->model->latest()->paginate(10);
        return CategoryResource::collection($categories)->additional([
            'message' => "All categories fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return CategoryResource
     */
    public function getSingleCategoryAction($slug): CategoryResource
    {
        $category = $this->model->whereSlug($slug)->firstOrFail();
        return (new CategoryResource($category))->additional( [
            'message' => "Category details fetched successfully",
            'success' => true
        ], Response::HTTP_OK);
    }

    /**
     * @param $request
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function updateCategoryAction($request, $slug): JsonResponse
    {
        $category = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $category->update([
                'name' => empty($request->name) ? $category->name : $request->name,
                'description' => empty($request->description) ? $category->description : $request->description,
                'annual_payment' => empty($request->annualPayment) ? $category->annual_payment : $request->annualPayment
            ]);
            return response()->json([
                'message' => 'Category update successfully',
                'data' => new CategoryResource($category),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to update category", $e->getMessage());
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws DatabaseException
     */
    public function deleteCategoryAction($slug): JsonResponse
    {
        $category = $this->model->whereSlug($slug)->firstOrFail();
        try {
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully',
                'data' => new CategoryResource($category),
                'success' => true
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw  new DatabaseException("Sorry unable to delete category", $e->getMessage());
        }
    }

}

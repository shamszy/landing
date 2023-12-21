<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\Request;

/**
 * CategoryController
 */
class CategoryController extends Controller
{
    /**
     * @param CategoryRepositoryInterface $repository
     */
    public function __construct(private readonly CategoryRepositoryInterface $repository)
    {}

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->repository->getAllCategories();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->repository->createCategory($request);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function show(string $slug): mixed
    {
        return $this->repository->getSingleCategory($slug);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return mixed
     */
    public function update(Request $request, string $slug): mixed
    {
        return $this->repository->updateCategory($request, $slug);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function destroy(string $slug): mixed
    {
        return $this->repository->deleteCategory($slug);
    }

}

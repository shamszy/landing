<?php

namespace App\Libs\Repositories\Contracts;

/**
 * CategoryRepositoryInterface
 */
interface CategoryRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function createCategory($request): mixed;

    /**
     * @return mixed
     */
    public function getAllCategories(): mixed;

    /**
     * @param $slug
     * @return mixed
     */
    public function getSingleCategory($slug): mixed;

    /**
     * @param $request
     * @param $slug
     * @return mixed
     */
    public function updateCategory($request, $slug): mixed;

    /**
     * @param $slug
     * @return mixed
     */
    public function deleteCategory($slug): mixed;
}

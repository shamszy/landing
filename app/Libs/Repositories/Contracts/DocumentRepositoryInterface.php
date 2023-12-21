<?php

namespace App\Libs\Repositories\Contracts;

/**
 * DocumentRepositoryInterface
 */
interface DocumentRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function createDocument($request): mixed;

    /**
     * @return mixed
     */
    public function getAllDocuments(): mixed;

    /**
     * @param $slug
     * @return mixed
     */
    public function getSingleDocument($slug): mixed;

    /**
     * @param $request
     * @param $slug
     * @return mixed
     */
    public function updateDocument($request, $slug): mixed;

    /**
     * @param $slug
     * @return mixed
     */
    public function deleteDocument($slug): mixed;
}

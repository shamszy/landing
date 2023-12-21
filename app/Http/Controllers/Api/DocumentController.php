<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\DocumentRepositoryInterface;
use Illuminate\Http\Request;

/**
 * DocumentController
 */
class DocumentController extends Controller
{
    /**
     * @param DocumentRepositoryInterface $repository
     */
    public function __construct(private readonly DocumentRepositoryInterface $repository)
    {}

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->repository->getAllDocuments();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->repository->createDocument($request);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function show(string $slug): mixed
    {
        return $this->repository->getSingleDocument($slug);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return mixed
     */
    public function update(Request $request, string $slug): mixed
    {
        return $this->repository->updateDocument($request, $slug);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function destroy(string $slug): mixed
    {
        return $this->repository->deleteDocument($slug);
    }

}

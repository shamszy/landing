<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\Request;

/**
 * CompanyController
 */
class CompanyController extends Controller
{
    /**
     * @param CompanyRepositoryInterface $repository
     */
    public function __construct(private readonly CompanyRepositoryInterface $repository)
    {}

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->repository->getAllCompanies();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->repository->createCompany($request);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function show(string $slug): mixed
    {
        return $this->repository->getSingleCompany($slug);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return mixed
     */
    public function update(Request $request, string $slug): mixed
    {
        return $this->repository->updateCompany($request, $slug);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function destroy(string $slug): mixed
    {
        return $this->repository->deleteCompany($slug);
    }

}

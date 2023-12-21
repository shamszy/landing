<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Repositories\Contracts\LicenseRepositoryInterface;
use Illuminate\Http\Request;

/**
 * LicenseController
 */
class LicenseController extends Controller
{
    /**
     * @param LicenseRepositoryInterface $repository
     */
    public function __construct(private readonly LicenseRepositoryInterface $repository)
    {}

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->repository->getAllLicenses();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->repository->addLicense($request);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function show(string $slug): mixed
    {
        return $this->repository->getSingleLicense($slug);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return mixed
     */
    public function update(Request $request, string $slug): mixed
    {
        return $this->repository->updateLicense($request, $slug);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function destroy(string $slug): mixed
    {
        return $this->repository->deleteLicense($slug);
    }

}

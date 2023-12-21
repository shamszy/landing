<?php

namespace App\Libs\Repositories\Contracts;

/**
 * LicenseRepositoryInterface
 */
interface LicenseRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function addLicense($request): mixed;

    /**
     * @return mixed
     */
    public function getAllLicenses(): mixed;

    /**
     * @param $slug
     * @return mixed
     */
    public function getSingleLicense($slug): mixed;

    /**
     * @param $request
     * @param $slug
     * @return mixed
     */
    public function updateLicense($request, $slug): mixed;

    /**
     * @param $slug
     * @return mixed
     */
    public function deleteLicense($slug): mixed;
}

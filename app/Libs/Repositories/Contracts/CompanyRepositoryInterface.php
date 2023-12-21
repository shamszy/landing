<?php

namespace App\Libs\Repositories\Contracts;

interface CompanyRepositoryInterface
{
    public function createCompany($request);
    public function getAllCompanies();
    public function getSingleCompany($slug);
    public function updateCompany($request, $slug);
    public function deleteCompany($slug);
}

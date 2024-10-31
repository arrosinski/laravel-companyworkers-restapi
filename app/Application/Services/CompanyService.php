<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Repositories\CompanyRepositoryInterface;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAllCompanies()
    {
        return $this->companyRepository->all();
    }

    public function getCompanyById($id)
    {
        return $this->companyRepository->find($id);
    }

    public function createCompany(array $data)
    {
        return $this->companyRepository->create($data);
    }

    public function updateCompany($id, array $data)
    {
        $company = $this->companyRepository->find($id);
        return $this->companyRepository->update($company, $data);
    }

    public function deleteCompany($id)
    {
        $company = $this->companyRepository->find($id);
        $this->companyRepository->delete($company);
    }
}

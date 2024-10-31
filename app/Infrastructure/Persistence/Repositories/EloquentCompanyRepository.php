<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Company;
use App\Domain\Repositories\CompanyRepositoryInterface;

class EloquentCompanyRepository implements CompanyRepositoryInterface
{
    public function all()
    {
        return Company::all();
    }

    public function find($id)
    {
        return Company::find($id);
    }

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function update(Company $company, array $data)
    {
        $company->update($data);
        return $company;
    }

    public function delete(Company $company)
    {
        $company->delete();
    }
}

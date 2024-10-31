<?php
declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Company;

interface CompanyRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Company $company, array $data);
    public function delete(Company $company);
}

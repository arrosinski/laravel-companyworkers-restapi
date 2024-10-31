<?php
declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Employee;

interface EmployeeRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Employee $employee, array $data);
    public function delete(Employee $employee);
}

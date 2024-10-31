<?php
declare(strict_types=1);


namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Employee;
use App\Domain\Repositories\EmployeeRepositoryInterface;

class EloquentEmployeeRepository implements EmployeeRepositoryInterface
{
    public function all()
    {
        return Employee::all();
    }

    public function find($id)
    {
        return Employee::find($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data)
    {
        $employee->update($data);
        return $employee;
    }

    public function delete(Employee $employee)
    {
        $employee->delete();
    }
}

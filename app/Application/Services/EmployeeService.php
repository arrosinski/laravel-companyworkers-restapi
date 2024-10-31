<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Repositories\EmployeeRepositoryInterface;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAllEmployees()
    {
        return $this->employeeRepository->all();
    }

    public function getEmployeeById($id)
    {
        return $this->employeeRepository->find($id);
    }

    public function createEmployee(array $data)
    {
        return $this->employeeRepository->create($data);
    }

    public function updateEmployee($id, array $data)
    {
        $employee = $this->employeeRepository->find($id);
        return $this->employeeRepository->update($employee, $data);
    }

    public function deleteEmployee($id)
    {
        $employee = $this->employeeRepository->find($id);
        $this->employeeRepository->delete($employee);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Services\EmployeeService;
use App\Domain\Exceptions\EmployeeNotFoundException;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        return $this->employeeService->getAllEmployees();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'nullable|string|max:255',
        ]);

        return $this->employeeService->createEmployee($validated);
    }

    public function show($id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        if (! $employee) {
            throw new EmployeeNotFoundException;
        }

        return $employee;
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'nullable|string|max:255',
        ]);

        return $this->employeeService->updateEmployee($id, $validated);
    }

    public function destroy($id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        if (! $employee) {
            throw new EmployeeNotFoundException;
        }

        $this->employeeService->deleteEmployee($id);

        return response()->noContent();
    }
}

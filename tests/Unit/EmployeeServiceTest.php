<?php

use App\Application\Services\EmployeeService;
use App\Domain\Entities\Employee;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->mockEmployeeRepository = Mockery::mock(EmployeeRepositoryInterface::class);
    $this->employeeService = new EmployeeService($this->mockEmployeeRepository);
});

test('create employee through service', function () {
    $data = [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => 'jane.doe@example.com',
        'phone' => '098-765-4321',
        'company_id' => 1,
    ];

    $this->mockEmployeeRepository->shouldReceive('create')->with($data)->andReturn(new Employee($data));

    $result = $this->employeeService->createEmployee($data);
    expect($result)->toBeInstanceOf(Employee::class)
        ->and($result->first_name)->toBe('Jane');
    $this->assertDatabaseHas('employees', ['email' => 'jane.doe@example.com']);
});

test('get all employees through service', function () {
    $employees = Employee::factory()->count(3)->make();
    $this->mockEmployeeRepository->shouldReceive('all')->andReturn($employees);

    $result = $this->employeeService->getAllEmployees();
    expect($result)->toHaveCount(3);
});

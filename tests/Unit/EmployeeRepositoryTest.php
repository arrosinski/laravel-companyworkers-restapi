<?php

use App\Domain\Entities\Employee;
use App\Infrastructure\Persistence\Repositories\EloquentEmployeeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->employeeRepository = new EloquentEmployeeRepository;
});

test('all employees', function () {
    Employee::factory()->count(3)->create();
    $result = $this->employeeRepository->all();
    expect($result)->toHaveCount(3);
});

test('create employee', function () {
    $data = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'phone' => '123-456-7890',
        'company_id' => 1,
    ];

    $result = $this->employeeRepository->create($data);
    expect($result)->toBeInstanceOf(Employee::class)
        ->and($result->first_name)->toBe('John');
    $this->assertDatabaseHas('employees', ['email' => 'john.doe@example.com']);
});

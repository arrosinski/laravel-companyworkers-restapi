<?php

use App\Domain\Entities\Employee;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use Mockery;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    protected $mockEmployeeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockEmployeeRepository = Mockery::mock(EmployeeRepositoryInterface::class);
    }

    public function testAllEmployees()
    {
        $employees = Employee::factory()->count(3)->make();
        $this->mockEmployeeRepository->shouldReceive('all')->once()->andReturn($employees);

        $result = $this->mockEmployeeRepository->all();
        $this->assertCount(3, $result);
    }

    public function testCreateEmployee()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '123-456-7890',
            'company_id' => 1,
        ];

        $employee = new Employee($data);
        $this->mockEmployeeRepository->shouldReceive('create')->once()->with($data)->andReturn($employee);

        $result = $this->mockEmployeeRepository->create($data);
        $this->assertInstanceOf(Employee::class, $result);
        $this->assertEquals('John', $result->first_name);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

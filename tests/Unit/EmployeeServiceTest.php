<?php

use App\Application\Services\EmployeeService;
use App\Domain\Entities\Employee;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use Mockery;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    protected $mockEmployeeRepository;
    protected $employeeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockEmployeeRepository = Mockery::mock(EmployeeRepositoryInterface::class);
        $this->employeeService = new EmployeeService($this->mockEmployeeRepository);
    }

    public function testCreateEmployeeThroughService()
    {
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'phone' => '098-765-4321',
            'company_id' => 1,
        ];

        $employee = new Employee($data);
        $this->mockEmployeeRepository->shouldReceive('create')->with($data)->andReturn($employee);

        $result = $this->employeeService->createEmployee($data);
        $this->assertInstanceOf(Employee::class, $result);
        $this->assertEquals('Jane', $result->first_name);
    }

    public function testGetAllEmployeesThroughService()
    {
        $employees = Employee::factory()->count(3)->make();
        $this->mockEmployeeRepository->shouldReceive('all')->andReturn($employees);

        $result = $this->employeeService->getAllEmployees();
        $this->assertCount(3, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

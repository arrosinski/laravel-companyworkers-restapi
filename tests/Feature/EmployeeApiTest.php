<?php

namespace Tests\Feature;

use App\Domain\Entities\Company;
use App\Domain\Entities\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllEmployees()
    {
        $company = Company::factory()->create();

        Employee::factory()->count(3)->create([
            'company_id' => $company->id,
        ]);

        $response = $this->getJson('/api/employees');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function testCreateEmployee()
    {
        $company = Company::factory()->create();

        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'phone_number' => '098-765-4321',
            'company_id' => $company->id,
        ];

        $response = $this->postJson('/api/employees', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['email' => 'jane.doe@example.com']);

        $this->assertDatabaseHas('employees', ['email' => 'jane.doe@example.com']);
    }

    public function testUpdateEmployee()
    {
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $data = [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@example.com',
            'phone_number' => '123-456-7890',
            'company_id' => $company->id,
        ];

        $response = $this->putJson("/api/employees/{$employee->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => 'john.smith@example.com']);

        $this->assertDatabaseHas('employees', ['email' => 'john.smith@example.com']);
    }

    public function testDeleteEmployee()
    {
        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }
}

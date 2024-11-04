<?php

namespace Tests\Feature;

use App\Models\User;
use App\Domain\Entities\Company;
use App\Domain\Entities\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();

        $employeeData = [
            'company_id' => $company->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '1234567890',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/employees', $employeeData);

        $response->assertStatus(201)
            ->assertJson(['first_name' => 'John']);
    }

    public function test_update_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $updatedData = [
            'company_id' => $company->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'phone_number' => '0987654321',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson('/api/employees/'.$employee->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson(['first_name' => 'Jane']);
    }

    public function test_show_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/employees/'.$employee->id);

        $response->assertStatus(200)
            ->assertJson(['first_name' => $employee->first_name]);
    }

    public function test_delete_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create(['company_id' => $company->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->deleteJson('/api/employees/'.$employee->id);

        $response->assertStatus(204);
    }

    public function test_show_non_existent_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/employees/999');

        $response->assertStatus(404)
            ->assertJson(['error' => 'Employee not found']);
    }

    public function test_create_employee_with_invalid_data()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $employeeData = [
            'company_id' => '',
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone_number' => '',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/employees', $employeeData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'company_id',
                'first_name',
                'last_name',
                'email',
            ]);
    }
}

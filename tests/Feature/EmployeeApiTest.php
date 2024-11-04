<?php

namespace Tests\Feature;

use App\Domain\Entities\Company;
use App\Domain\Entities\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123-456-7890',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->deleteJson('/api/employees/'.$employee->id);

        $response->assertStatus(204);
    }

    public function test_show_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123-456-7890',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/employees/'.$employee->id);

        $response->assertStatus(200)
            ->assertJson([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone_number' => '123-456-7890',
            ]);
    }

    public function test_update_employee()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123-456-7890',
        ]);

        $updatedData = [
            'company_id' => $company->id,
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'email' => 'updated@example.com',
            'phone_number' => '987-654-3210',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson('/api/employees/'.$employee->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson(['first_name' => 'Updated First Name']);
    }
    public function test_create_employee_with_missing_fields()
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
            ->assertJsonValidationErrors(['company_id', 'first_name', 'last_name', 'email']);
    }

    public function test_update_employee_with_invalid_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123-456-7890',
        ]);

        $updatedData = [
            'company_id' => $company->id,
            'first_name' => 'Updated First Name',
            'last_name' => 'Updated Last Name',
            'email' => 'invalid-email',
            'phone_number' => '987-654-3210',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson('/api/employees/'.$employee->id, $updatedData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}

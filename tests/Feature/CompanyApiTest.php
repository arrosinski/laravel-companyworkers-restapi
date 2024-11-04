<?php

namespace Tests\Feature;

use App\Models\User;
use App\Domain\Entities\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_company()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $companyData = [
            'name' => 'Test Company',
            'address' => '123 Test Street',
            'tax_identification_number' => '123456789',
            'city' => 'Test City',
            'postal_code' => '12345',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/companies', $companyData);

        $response->assertStatus(201)
            ->assertJson(['name' => 'Test Company']);
    }

    public function test_update_company()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $company = Company::factory()->create();

        $updatedData = [
            'name' => 'Updated Company',
            'address' => '456 Updated Street',
            'tax_identification_number' => '987654321',
            'city' => 'Updated City',
            'postal_code' => '54321',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson('/api/companies/'.$company->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Updated Company']);
    }

    public function test_show_non_existent_company()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('/api/companies/999');

        $response->assertStatus(404)
            ->assertJson(['error' => 'Company not found']);
    }

    public function test_create_company_with_invalid_data()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $companyData = [
            'name' => '',
            'address' => '',
            'tax_identification_number' => '',
            'city' => '',
            'postal_code' => '',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson('/api/companies', $companyData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'address',
                'tax_identification_number',
                'city',
                'postal_code',
            ]);
    }
}

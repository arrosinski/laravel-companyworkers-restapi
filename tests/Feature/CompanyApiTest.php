<?php

namespace Tests\Feature;

use App\Domain\Entities\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllCompanies()
    {
        Company::factory()->count(3)->create();

        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function testCreateCompany()
    {
        $data = [
            'name' => 'Acme Corporation',
            'tax_identification_number' => '123456789',
            'address' => '123 Acme St',
            'city' => 'Acme City',
            'postal_code' => '12345',
        ];

        $response = $this->postJson('/api/companies', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Acme Corporation']);

        $this->assertDatabaseHas('companies', ['name' => 'Acme Corporation']);
    }
    public function testUpdateCompany()
    {
        $company = Company::factory()->create();

        $data = [
            'name' => 'Updated Corporation',
            'tax_identification_number' => '987654321',
            'address' => '456 Updated St',
            'city' => 'Updated City',
            'postal_code' => '54321',
        ];

        $response = $this->putJson("/api/companies/{$company->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Corporation']);

        $this->assertDatabaseHas('companies', ['name' => 'Updated Corporation']);
    }
    public function testDeleteCompany()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson("/api/companies/{$company->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }
}

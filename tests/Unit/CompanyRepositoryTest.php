<?php

use App\Domain\Entities\Company;
use App\Infrastructure\Persistence\Repositories\EloquentCompanyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->companyRepository = new EloquentCompanyRepository;
});

test('all companies', function () {
    Company::factory()->count(3)->create();
    $result = $this->companyRepository->all();
    expect($result)->toHaveCount(3);
});

test('create company', function () {
    $data = [
        'name' => 'Test Company',
        'tax_identification_number' => '123456789',
        'address' => '123 Test St',
        'city' => 'Test City',
        'postal_code' => '12345',
    ];

    $result = $this->companyRepository->create($data);
    expect($result)->toBeInstanceOf(Company::class)
        ->and($result->name)->toBe('Test Company');
    $this->assertDatabaseHas('companies', ['name' => 'Test Company']);
});

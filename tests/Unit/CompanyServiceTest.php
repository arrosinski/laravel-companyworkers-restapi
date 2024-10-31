<?php

use App\Application\Services\CompanyService;
use App\Domain\Entities\Company;
use App\Domain\Repositories\CompanyRepositoryInterface;
use Mockery;

beforeEach(function () {
    $this->companyRepository = Mockery::mock(CompanyRepositoryInterface::class);
    $this->companyService = new CompanyService($this->companyRepository);
});

afterEach(function () {
    Mockery::close();
});

test('get all companies', function () {
    $this->companyRepository->shouldReceive('all')->once()->andReturn(collect([new Company]));
    $result = $this->companyService->getAllCompanies();
    expect($result)->toHaveCount(1);
});

test('create company', function () {
    $data = [
        'name' => 'Test Company',
        'tax_identification_number' => '123456789',
        'address' => '123 Test St',
        'city' => 'Test City',
        'postal_code' => '12345',
    ];

    $this->companyRepository->shouldReceive('create')->once()->with($data)->andReturn(new Company($data));
    $result = $this->companyService->createCompany($data);
    expect($result)->toBeInstanceOf(Company::class)
        ->and($result->name)->toBe('Test Company');
});

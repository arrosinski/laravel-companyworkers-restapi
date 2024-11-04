<?php

use App\Domain\Entities\Company;
use App\Domain\Repositories\CompanyRepositoryInterface;
use Mockery;
use Tests\TestCase;

class CompanyRepositoryTest extends TestCase
{
    protected $mockCompanyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockCompanyRepository = Mockery::mock(CompanyRepositoryInterface::class);
    }

    public function testAllCompanies()
    {
        $companies = collect([new Company]);
        $this->mockCompanyRepository->shouldReceive('all')->once()->andReturn($companies);

        $result = $this->mockCompanyRepository->all();
        $this->assertCount(1, $result);
    }

    public function testCreateCompany()
    {
        $data = [
            'name' => 'Test Company',
            'tax_identification_number' => '123456789',
            'address' => '123 Test St',
            'city' => 'Test City',
            'postal_code' => '12345',
        ];

        $company = new Company($data);
        $this->mockCompanyRepository->shouldReceive('create')->once()->with($data)->andReturn($company);

        $result = $this->mockCompanyRepository->create($data);
        $this->assertInstanceOf(Company::class, $result);
        $this->assertEquals('Test Company', $result->name);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

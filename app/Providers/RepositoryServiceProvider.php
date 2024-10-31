<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Repositories\CompanyRepositoryInterface;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentCompanyRepository;
use App\Infrastructure\Persistence\Repositories\EloquentEmployeeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CompanyRepositoryInterface::class, EloquentCompanyRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EloquentEmployeeRepository::class);
    }

    public function boot()
    {
        //
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        return $this->companyService->getAllCompanies();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tax_identification_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
        ]);

        return $this->companyService->createCompany($validated);
    }

    public function show($id)
    {
        return $this->companyService->getCompanyById($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tax_identification_number' => 'required|regex:/^\d{9}$/',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|regex:/^\d{5}$/',
        ]);

        return $this->companyService->updateCompany($id, $validated);
    }

    public function destroy($id)
    {
        $this->companyService->deleteCompany($id);
        return response()->noContent();
    }
}

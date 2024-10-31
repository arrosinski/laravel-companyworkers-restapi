<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('companies', CompanyController::class);
Route::apiResource('employees', EmployeeController::class);

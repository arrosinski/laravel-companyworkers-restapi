<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class EmployeeNotFoundException extends Exception
{
    protected $message = 'Employee not found';

    public function render($request)
    {
        return response()->json(['error' => $this->message], 404);
    }
}

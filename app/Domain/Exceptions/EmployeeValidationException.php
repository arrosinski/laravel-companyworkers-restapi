<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

use Exception;

class EmployeeValidationException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render($request)
    {
        return response()->json(['error' => $this->message], 422);
    }
}

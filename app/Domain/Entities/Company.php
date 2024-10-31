<?php

namespace App\Domain\Entities;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'tax_identification_number', 'address', 'city', 'postal_code'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    protected static function newFactory()
    {
        return CompanyFactory::new();
    }
}

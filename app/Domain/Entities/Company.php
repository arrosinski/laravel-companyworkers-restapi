<?php

namespace App\Domain\Entities;

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
}

<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'email', 'phone_number'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'surname',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'physical_address',
        'insurance_information'
    ];

    public function labResults(): HasMany
    {
        return $this->hasMany(LabResult::class);
    }
}

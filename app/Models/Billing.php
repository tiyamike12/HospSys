<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'billing_date', 'amount', 'payment_status',

    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function pharmacyItems(): BelongsToMany
    {
        return $this->belongsToMany(Pharmacy::class)->withPivot('quantity');
    }

    public function labTests(): BelongsToMany
    {
        return $this->belongsToMany(LabTest::class)->withPivot('quantity');
    }

    public function insuranceProvider(): BelongsTo
    {
        return $this->belongsTo(InsuranceProvider::class);
    }

}

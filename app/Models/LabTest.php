<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_name', 'description', 'lab_charges',
    ];

    public function billingInvoices(): BelongsToMany
    {
        return $this->belongsToMany(Billing::class)->withPivot('quantity');
    }

//    public function medicalRecords(): BelongsToMany
//    {
//        return $this->belongsToMany(MedicalRecord::class)->withPivot('result');
//    }

    public function medicalRecords(): BelongsToMany
    {
        return $this->belongsToMany(MedicalRecord::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}

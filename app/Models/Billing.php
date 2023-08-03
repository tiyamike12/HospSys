<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Billing extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'patient_id', 'billing_date', 'amount', 'payment_status', 'medical_record_id', 'insurance_provider_id'
    ];

    //"pending," "paid," "rejected,"

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function pharmacyItems(): BelongsToMany
    {
        return $this->belongsToMany(PharmacyItem::class)->withPivot('quantity');
    }

    public function labTests(): BelongsToMany
    {
        return $this->belongsToMany(LabTest::class)->withPivot('quantity');
    }

    public function insuranceProvider(): BelongsTo
    {
        return $this->belongsTo(InsuranceProvider::class);
    }

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function scopeTotalPendingAmount($query)
    {
        return $query->where('payment_status', 'pending')->sum('amount');
    }

    public function scopeTotalPaidAmount($query)
    {
        return $query->where('payment_status', 'paid')->sum('amount');
    }

    public function scopeTotalRejectedAmount($query)
    {
        return $query->where('payment_status', 'rejected')->sum('amount');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'billing_date', 'amount', 'payment_status', 'medical_record_id', 'insurance_provider_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}

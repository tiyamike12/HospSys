<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'firstname', 'surname', 'date_of_birth', 'gender', 'phone', 'email', 'physical_address', 'provider_id', 'provider_number'
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function billingInvoices(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function insuranceProvider(): BelongsTo
    {
        return $this->belongsTo(InsuranceProvider::class, 'provider_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['firstname', 'surname', 'date_of_birth', 'gender', 'phone', 'email', 'physical_address', 'provider_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}

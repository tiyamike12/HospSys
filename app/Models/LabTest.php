<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LabTest extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['test_name', 'description', 'lab_charges'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}

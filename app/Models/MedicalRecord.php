<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MedicalRecord extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'patient_id', 'user_id', 'medical_notes', 'diagnoses', 'prescriptions'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    public function labTests(): BelongsToMany
//    {
//        return $this->belongsToMany(LabTest::class)->withPivot('result');
//    }

    public function labTests(): BelongsToMany
    {
        return $this->belongsToMany(LabTest::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'user_id', 'medical_notes', 'diagnoses', 'prescriptions'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}

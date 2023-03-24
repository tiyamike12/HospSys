<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'visit_date',
        'lab_result_id',
        'diagnoses',
        'treatment_plan',
        'test_results'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

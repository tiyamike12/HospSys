<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'test_date',
        'test_name',
        'test_result'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'admission_date',
        'discharge_date',
        'reason',
        'status'
    ];
}

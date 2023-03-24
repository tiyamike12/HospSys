<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'ward_id',
        'bed_id',
        'admission_date',
        'discharge_date',
        'admission_reason',
        'admission_reason',
        'status',
    ];
}

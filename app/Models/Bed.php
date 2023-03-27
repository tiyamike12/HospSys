<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'ward_id',
        'patient_id',
        'bed_type',
        'bed_status',
        'admission_date',
        'discharge_date',
    ];
}

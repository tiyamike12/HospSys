<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'service_date',
        'service_type',
        'cost',
        'insurance_information',
        'payment_status',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_name',
        'dosage',
        'quantity',
        'manufacturer',
        'expiration_date'
    ];
}

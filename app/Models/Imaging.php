<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imaging extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'imaging_date',
        'imaging_type',
        'imaging_results',
        'status',
    ];
}

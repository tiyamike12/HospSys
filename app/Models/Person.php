<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'physical_address',
        'user_id',
        'job_title'
    ];

    // No table associated with this model as it serves as a base model.
    //public $table = false;

}

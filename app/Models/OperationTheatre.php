<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperationTheatre extends Model
{
    use HasFactory;

    protected $fillable = [
        'theatre_name', 'description', 'availability',

    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

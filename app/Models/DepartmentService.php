<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepartmentService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'description',
        'department_id', // Foreign key to link to the Department model
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}

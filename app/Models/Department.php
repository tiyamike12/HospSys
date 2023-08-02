<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'department_name', 'description',

    ];

    public function persons(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(DepartmentService::class);
    }

//    public function appointments(): HasMany
//    {
//        return $this->hasMany(Appointment::class);
//    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([ 'department_name', 'description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}

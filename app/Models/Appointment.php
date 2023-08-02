<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Appointment extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'patient_id', 'user_id', 'appointment_date', 'appointment_time', 'purpose', 'status'
    ];


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getStatusStatistics()
    {
        return Appointment::select(
            DB::raw("COUNT(CASE WHEN status = 'scheduled' THEN 1 END) as scheduled"),
            DB::raw("COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed"),
            DB::raw("COUNT(CASE WHEN status = 'canceled' THEN 1 END) as canceled")
        )->first();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'user_id', 'appointment_date', 'appointment_time'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}

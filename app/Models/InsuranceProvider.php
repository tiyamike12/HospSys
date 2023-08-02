<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InsuranceProvider extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'provider_name', 'contact_information',
    ];

    public function billingInvoices(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['provider_name', 'contact_information'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}

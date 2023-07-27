<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name', 'contact_information',
    ];

    public function billingInvoices(): HasMany
    {
        return $this->hasMany(Billing::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PharmacyItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name', 'description', 'quantity_available', 'unit_price',

    ];

    public function billingInvoices(): BelongsToMany
    {
        return $this->belongsToMany(Billing::class)->withPivot('quantity');
    }
}

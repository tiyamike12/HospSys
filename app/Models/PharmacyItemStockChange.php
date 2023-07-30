<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyItemStockChange extends Model
{
    use HasFactory;

    protected $fillable = ['pharmacy_item_id', 'quantity_change', 'change_type'];

    public function pharmacyItem()
    {
        return $this->belongsTo(PharmacyItem::class);
    }
}

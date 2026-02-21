<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    //
    protected $fillable = [
        'item_name',
        'unit',
        'length',
        'value',
        'prorate_value',
        'quotation_id',
        'description',
        'unit_price',
        'subtotal',
    ];
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialReceipts extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'received_date',
        'note',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function items()
    {
        return $this->hasMany(MaterialReceiptItem::class);
    }
}

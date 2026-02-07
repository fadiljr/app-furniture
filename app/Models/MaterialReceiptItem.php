<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialReceiptItem extends Model
{
    protected $fillable = [
        'material_receipt_id',
        'material_id',
        'qty_received',
    ];

    public function receipt()
    {
        return $this->belongsTo(MaterialReceipts::class, 'material_receipt_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}

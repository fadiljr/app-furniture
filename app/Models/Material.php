<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'stock',
        'price',
    ];
    public function estimations()
    {
        return $this->hasMany(ProjectMaterialEstimation::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function receiptItems()
    {
        return $this->hasMany(MaterialReceiptItem::class);
    }

    public function usages()
    {
        return $this->hasMany(MaterialUsages::class);
    }
}

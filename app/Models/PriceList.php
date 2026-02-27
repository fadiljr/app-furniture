<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    //
    protected $fillable = [
        'item_name',
        'price',
        'unit',
        'size',
        'description',
    ];
}

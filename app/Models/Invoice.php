<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'project_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'grand_total',
        'discount',
        'tax',
        'status',
    ];
}

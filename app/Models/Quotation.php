<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //
    protected $fillable = [
        'quotation_number',
        'client_name',
        'client_address',
        'quotation_date',
        'valid_until',
        'total_amount',
        'discount',
        'tax',
        'grand_total',
        'status',
        'notes',
    ];
    public static function generateQuotationNumber()
    {
        $today = now()->format('Ymd');

        $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'QTN' . $today . '' . str_pad($countToday, 3, '0', STR_PAD_LEFT);
    }
     protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->quotation_number = self::generateQuotationNumber();
         });
     }
     public function items()
     {
         return $this->hasMany(QuotationItem::class);
     }
}

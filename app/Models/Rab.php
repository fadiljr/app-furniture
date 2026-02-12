<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    protected $fillable = [
        'project_id',
        'nomor_rab',
        'tanggal',
        'expired_date',
        'subtotal',
        'diskon',
        'pajak',
        'grand_total',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(RabItem::class);
    }

     public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}


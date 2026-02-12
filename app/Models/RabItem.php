<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    protected $fillable = [
        'rab_id',
        'nama_item',
        'deskripsi',
        'satuan',
        'volume',
        'harga_satuan',
        'total'
    ];

    public function rab()
    {
        return $this->belongsTo(Rab::class);
    }
}


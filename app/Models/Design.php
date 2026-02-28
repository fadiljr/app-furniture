<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
    'design_id',
    'file_path',
    'description',
];

protected $casts = [
    'file_path' => 'array', // WAJIB
];
}

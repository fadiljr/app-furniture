<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionTask extends Model
{
    protected $fillable = [
        'production_id',
        'task_name',
        'is_done',
        'worker_name',
    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}

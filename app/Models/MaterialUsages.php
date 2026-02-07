<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialUsages extends Model
{
    protected $fillable = [
        'project_id',
        'material_id',
        'qty_used',
        'used_date',
        'note',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}

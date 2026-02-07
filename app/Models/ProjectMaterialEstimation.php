<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMaterialEstimation extends Model
{
    protected $fillable = [
        'project_id',
        'material_id',
        'qty_estimated',
        'unit',
        'estimated_price',
        'subtotal',
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

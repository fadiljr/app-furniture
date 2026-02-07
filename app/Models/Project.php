<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'project_type',
        'address',
        'size',
        'material_spec',
        'status',
        'estimated_cost',
        'total_paid',
        'start_date',
        'end_date',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function materialEstimations()
    {
        return $this->hasMany(ProjectMaterialEstimation::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function materialUsages()
    {
        return $this->hasMany(MaterialUsages::class);
    }
    public function getTotalMaterialEstimatedAttribute()
    {
        return $this->materialEstimations()->sum('subtotal');
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }
}

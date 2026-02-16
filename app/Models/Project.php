<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public static function generateProjectNumber()
    {
        $today = now()->format('Ymd');

        $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'PRO' . $today . '' . str_pad($countToday, 3, '0', STR_PAD_LEFT);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $project->project_number = self::generateProjectNumber();
        });
    }
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
    public function surveys()
    {
        return $this->hasOne(Survey::class);
    }
    public function rab()
    {
        return $this->hasOne(Rab::class);
    }
}

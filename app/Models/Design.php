<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'design_id',
        'project_id',
        'file_path',
        'description',
        'status',
        'deadline',
    ];
     public static function generateDesignNumber()
    {
        $today = now()->format('Ymd');

        $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'DSN' . $today . '' . str_pad($countToday, 3, '0', STR_PAD_LEFT);
    }
     protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->design_id = self::generateDesignNumber();
         });
     }
    protected $casts = [
        'file_path' => 'array', // WAJIB
        'deadline' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}

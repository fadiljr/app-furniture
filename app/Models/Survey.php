<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $fillable = [
        'project_id',
        'survey_date',
        'notes',
        'status',
        'attchments',
    ];
    protected $casts = [
    'attchments' => 'array',
];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    
}

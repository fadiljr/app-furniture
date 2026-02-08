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
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function surveyRooms()
    {
        return $this->hasMany(SurveyRoom::class, 'survey_id', 'id');
    }
}

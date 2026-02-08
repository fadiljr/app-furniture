<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRoom extends Model
{
    //
    protected $fillable = [
        'survey_id',
        'room_name',
        'length',
        'width',
        'height',
        'notes',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }   
}

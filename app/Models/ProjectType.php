<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}

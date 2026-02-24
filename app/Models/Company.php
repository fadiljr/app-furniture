<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'company_code',
        'address',
    ];
    public function clients()
{
    return $this->hasMany(Client::class);
}
}

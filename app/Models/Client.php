<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public static function generateClientCode()
    {
        $today = now()->format('ymd');

        $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'CLI' . $today . '' . str_pad($countToday, 3, '0', STR_PAD_LEFT);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            $client->client_code = $client->generateClientCode();
        });
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function company()
{
    return $this->belongsTo(Company::class);
}
}

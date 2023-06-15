<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    use HasFactory;

    protected $hidden = [
        'name',
        'address',
        'driver',
        'host',
        'port',
        'encryption',
        'username',
        'password'
    ];

    public function scopeConfiguredEmail($query, $useFor)
    {
        return $query->where('is_active', true)->where('use_for', $useFor);
    }
}

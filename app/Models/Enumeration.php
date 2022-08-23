<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enumeration extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }

    public function scopeFilter($query, array $filter)
    {
        return $query->when($filter['search'] ?? false, fn ($query, $search) => ($query->whereRaw("(LOWER(name) LIKE '%$search%' OR LOWER(name_hk) LIKE '%$search%' OR LOWER(category) LIKE '%$search%')")));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

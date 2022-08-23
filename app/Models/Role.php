<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    // protected $with = ['createUser','updateUser'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function createUser()
    {
        return $this->belongsTo(User::class,'user_created','id');
    }

    public function updateUser()
    {
        return $this->belongsTo(User::class,'user_updated','id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

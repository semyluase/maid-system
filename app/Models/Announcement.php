<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
        return $query->when($filter['search'] ?? false, fn ($query, $search) => $query->whereRaw("(title LIKE '%$search%')"));
    }
}

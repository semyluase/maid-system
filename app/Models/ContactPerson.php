<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filter)
    {
        return $query->when($filter['search'] ?? false, fn ($query, $search) => $query->whereRaw("(title LIKE '%$search%')"));
    }
}

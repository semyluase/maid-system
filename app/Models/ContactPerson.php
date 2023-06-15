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

    public function scopeContactSorted($query)
    {
        $query->select('*')
            ->fromRaw("(SELECT cp.id, cp.`name`, cp.`branch`, cp.`whatsapp`, cp.`code`,
            IFNULL(cps.id,9999) AS sort
            FROM contact_people cp
            LEFT JOIN contact_people_sort cps
            ON cp.`id` = cps.`contact_people_id`) tb");

        return $query;
    }
}

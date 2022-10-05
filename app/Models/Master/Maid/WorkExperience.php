<?php

namespace App\Models\Master\Maid;

use App\Models\Master\Maid\Maid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function maid()
    {
        return $this->belongsTo(Maid::class, 'maid_id', 'id');
    }

    public function scopeCountry($query, $country)
    {
        if ($country === "HK") $query->where('is_hongkong', true);
        if ($country === "SG") $query->where('is_singapore', true);
        if ($country === "TW") $query->where('is_taiwan', true);
        if ($country === "MY") $query->where('is_malaysia', true);
        if ($country === "BN") $query->where('is_brunei', true);
        if ($country === "ALL") $query->where('is_all_format', true);
        return $query;
    }
}

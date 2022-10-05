<?php

namespace App\Models\Master\Maid;

use App\Models\master\maid\Language;
use App\Models\master\maid\Other;
use App\Models\master\maid\Skill;
use App\Models\master\maid\WorkExperience;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maid extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'code_maid';
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
        return $query->when($filter['search'] ?? false, fn ($query, $search) => ($query->where('full_name', 'like', "%$search%")->whereOr('code_maid', 'like', "%$search%")));
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

    public function language()
    {
        return $this->hasMany(Language::class, 'maid_id', 'id');
    }

    public function skill()
    {
        return $this->hasMany(Skill::class, 'maid_id', 'id');
    }

    public function other()
    {
        return $this->hasMany(Other::class, 'maid_id', 'id');
    }

    public function workExperience()
    {
        return $this->hasMany(WorkExperience::class, 'maid_id', 'id');
    }

    public function interview()
    {
        return $this->hasMany(Interview::class, 'maid_id', 'id');
    }

    public function medical()
    {
        return $this->hasMany(Medical::class, 'maid_id', 'id');
    }
}

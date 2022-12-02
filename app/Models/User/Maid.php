<?php

namespace App\Models\User;

use App\Models\Master\Maid\Interview;
use App\Models\Master\Maid\Language;
use App\Models\Master\Maid\Medical;
use App\Models\Master\Maid\Other;
use App\Models\Master\Maid\Skill;
use App\Models\Master\Maid\WorkExperience;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Maid extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'maids';
    protected $guarded = ['id'];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created', 'id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }

    public function userTrashed()
    {
        return $this->belongsTo(User::class, 'user_trashed', 'id');
    }

    public function userBookmark()
    {
        return $this->belongsTo(User::class, 'user_bookmark', 'id');
    }

    public function userUploaded()
    {
        return $this->belongsTo(User::class, 'user_uploaded', 'id');
    }

    public function historyAction()
    {
        return $this->hasMany(HistoryTakenMaid::class, 'maid_id', 'id');
    }

    public function documentMaid()
    {
        return $this->hasMany(Document::class, 'maid_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'code_maid';
    }

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter['search'] ?? false, fn ($query, $search) => ($query->where('full_name', 'like', "%$search%")->orWhere('code_maid', 'like', "%$search%")->orWhere('date_of_birth', 'like', "%" . Carbon::now()->subYears(intval($search))->isoFormat('YYYY') . "%")));

        $query->when($filter['code'] ?? false, fn ($query, $search) => ($query->where("code_maid", "LIKE", "%$search%")));

        $query->when($filter['name'] ?? false, fn ($query, $search) => ($query->where("full_name", "LIKE", "%$search%")));

        if ($filter['start_age'] != '' || $filter['start_age'] != null) {
            $query->when($filter['start_age'] ?? false, fn ($query, $search) => ($query->orWhere("date_of_birth", "like", "%" . Carbon::now()->subYears($search)->isoFormat('YYYY') . "%")));
        }

        if ($filter['end_age'] != '' || $filter['end_age'] != null) {
            $query->when($filter['end_age'] ?? false, fn ($query, $search) => ($query->orWhere("date_of_birth", "like", "%" . Carbon::now()->subYears($search)->isoFormat('YYYY') . "%")));
        }

        $query->when($filter['education'] ?? false, fn ($query, $search) => ($query->where("education", "$search")));

        $query->when($filter['marital'] ?? false, fn ($query, $search) => ($query->where("marital", "$search")));

        return $query;
    }

    public function scopeCountry($query, $country)
    {
        if ($country === "HK") $query->where('is_hongkong', true);
        if ($country === "SG") $query->where('is_singapore', true);
        if ($country === "TW") $query->where('is_taiwan', true);
        if ($country === "MY") $query->where('is_malaysia', true);
        if ($country === "BN") $query->where('is_brunei', true);
        if ($country === "FM") $query->where('is_all_format', true);
        return $query;
    }

    public function scopeCountryUser($query, $country, $format)
    {
        if ($country === "HK" && $format == 0) $query->where('is_hongkong', true);
        if ($country === "SG" && $format == 0) $query->where('is_singapore', true);
        if ($country === "TW" && $format == 0) $query->where('is_taiwan', true);
        if ($country === "MY" && $format == 0) $query->where('is_malaysia', true);
        if ($country === "BN" && $format == 0) $query->where('is_brunei', true);
        if ($country === "BN" && $format == 1) $query->where('is_all_format', true)->whereRaw("LEFT(code_maid,1) = 'B'");
        if ($country === "MY" && $format == 1) $query->where('is_all_format', true)->whereRaw("LEFT(code_maid,1) = 'M'");
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

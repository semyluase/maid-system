<?php

namespace App\Models\Master\Maid;

use App\Models\Master\Maid\Language;
use App\Models\Master\Maid\Other;
use App\Models\Master\Maid\Skill;
use App\Models\Master\Maid\WorkExperience;
use App\Models\User;
use App\Models\User\Document;
use App\Models\User\HistoryTakenMaid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function userTaken()
    {
        return $this->belongsTo(User::class, 'user_taken', 'id');
    }

    public function scopeFilter($query, array $filter, $country)
    {
        $query->when($filter['search'] ?? false, fn ($query, $search) => ($query->where('full_name', 'like', "%$search%")->orWhere('code_maid', 'like', "%$search%")->orWhere('date_of_birth', 'like', "%" . Carbon::now()->subYears(intval($search))->isoFormat('YYYY') . "%")));

        $query->when($filter['code'] ?? false, fn ($query, $search) => ($query->where("code_maid", "LIKE", "%$search%")));

        $query->when($filter['name'] ?? false, fn ($query, $search) => ($query->where("full_name", "LIKE", "%$search%")));

        if ($filter['start_age'] != '' || $filter['start_age'] != null) {
            $query->when($filter['start_age'] ?? false, fn ($query, $search) => ($query->where("date_of_birth", "like", "%" . Carbon::now()->subYears($search)->isoFormat('YYYY') . "%")));
        }

        if ($filter['end_age'] != '' || $filter['end_age'] != null) {
            $query->when($filter['end_age'] ?? false, fn ($query, $search) => ($query->where("date_of_birth", "like", "%" . Carbon::now()->subYears($search)->isoFormat('YYYY') . "%")));
        }

        $query->when($filter['education'] ?? false, fn ($query, $search) => ($query->where("education", "$search")));

        $query->when($filter['marital'] ?? false, fn ($query, $search) => ($query->where("marital", "$search")));

        $query->when($filter['category'] ?? false, function ($query, $category) {
            if ($category == 'taken') {
                return $query->where('is_taken', true);
            }

            if ($category == 'hold') {
                return $query->where('is_bookmark', true);
            }

            if ($category == 'upload') {
                return $query->where('is_uploaded', true);
            }

            if ($category == 'avail') {
                return $query->where('is_uploaded', false)
                    ->where('is_bookmark', false)
                    ->where('is_uploaded', false);
            }
        });

        if ($country == '') {
            $query->when($filter['branch'] ?? false, function ($query, $branch) {
                if ($branch == 'K') {
                    return $query->whereRaw("(LEFT(code_maid,1) = 'K' OR RIGHT(LEFT(code_maid,2),1) = 'K')");
                }

                if ($branch == 'T') {
                    return $query->whereRaw("(LEFT(code_maid,1) = 'T' OR RIGHT(LEFT(code_maid,2),1) = 'T')");
                }

                if ($branch == 'G') {
                    return $query->whereRaw("(LEFT(code_maid,1) = 'G' OR RIGHT(LEFT(code_maid,2),1) = 'G')");
                }

                if ($branch == 'B') {
                    return $query->whereRaw("(LEFT(code_maid,1) = 'B' OR RIGHT(LEFT(code_maid,2),1) = 'B')");
                }
            });
        }

        if ($country != '' && $country != 'FM') {
            $query->when($filter['branch'] ?? false, function ($query, $branch) {
                if ($branch == 'K') {
                    return $query->whereRaw("LEFT(code_maid,1) = 'K'");
                }

                if ($branch == 'T') {
                    return $query->whereRaw("LEFT(code_maid,1) = 'T'");
                }

                if ($branch == 'G') {
                    return $query->whereRaw("LEFT(code_maid,1) = 'G'");
                }

                if ($branch == 'B') {
                    return $query->whereRaw("LEFT(code_maid,1) = 'B'");
                }
            });
        }

        if ($country != '' && $country == 'FM') {
            $query->when($filter['branch'] ?? false, function ($query, $branch) {
                if ($branch == 'K') {
                    return $query->whereRaw("RIGHT(LEFT(code_maid,2),1) = 'K'");
                }

                if ($branch == 'T') {
                    return $query->whereRaw("RIGHT(LEFT(code_maid,2),1) = 'T'");
                }

                if ($branch == 'G') {
                    return $query->whereRaw("RIGHT(LEFT(code_maid,2),1) = 'G'");
                }

                if ($branch == 'B') {
                    return $query->whereRaw("RIGHT(LEFT(code_maid,2),1) = 'B'");
                }
            });
        }

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

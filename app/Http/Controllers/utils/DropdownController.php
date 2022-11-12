<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Master\Maid\Maid;
use App\Models\Role;
use App\Models\User;
use App\Models\User\Maid as UserMaid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DropdownController extends Controller
{
    public function role()
    {
        $dataRole = Role::where('is_active', true)
            ->get();

        $results = array();

        if ($dataRole) {
            foreach ($dataRole as $row => $value) {
                $results[] = [
                    'label' =>  $value->description,
                    'value' =>  $value->id
                ];
            }
        }

        return response()->json($results);
    }

    public function country()
    {
        $dataCountry = Country::where('is_active', true)
            ->get();

        $results = array();

        if ($dataCountry) {
            foreach ($dataCountry as $row => $value) {
                $results[] = [
                    'label' =>  $value->code . '-' . $value->name,
                    'value' =>  $value->id
                ];
            }
        }

        return response()->json($results);
    }

    public function province(Request $request)
    {
        $uri = 'https://wilayah-indonesia.maisys.site/static/api/provinces.json';

        if ($request->province_id) {
            $uri = "https://wilayah-indonesia.maisys.site/static/api/province/$request->province_id.json";
        }

        $dataProvince = getAPI($uri);

        $results = array();

        if ($dataProvince) {
            if (collect($dataProvince)->count() == 1) {
                return response()->json($dataProvince);
            } else {
                foreach ($dataProvince as $key => $value) {
                    $results[] = [
                        'label' =>  $value->name,
                        'value' =>  $value->id
                    ];
                }
            }
        }

        return response()->json($results);
    }

    public function regency(Request $request)
    {
        $uri = "https://wilayah-indonesia.maisys.site/static/api/regencies/$request->province_id.json";

        if ($request->regency_id) {
            $uri = "https://wilayah-indonesia.maisys.site/static/api/regency/$request->regency_id.json";
        }

        $dataRegency = getAPI($uri);

        $results = array();

        if ($dataRegency) {
            if (collect($dataRegency)->count() == 1) {
                return response()->json($dataRegency);
            } else {
                foreach ($dataRegency as $key => $value) {
                    $results[] = [
                        'label' =>  $value->name,
                        'value' =>  $value->id
                    ];
                }
            }
        }

        return response()->json($results);
    }

    public function district(Request $request)
    {
        $uri = "https://wilayah-indonesia.maisys.site/static/api/districts/$request->regency_id.json";

        if ($request->district_id) {
            $uri = "https://wilayah-indonesia.maisys.site/static/api/district/$request->district_id.json";
        }

        $dataDistrict = getAPI($uri);

        $results = array();

        if ($dataDistrict) {
            if (collect($dataDistrict)->count() == 0) {
                return response()->json($dataDistrict);
            } else {
                foreach ($dataDistrict as $key => $value) {
                    $results[] = [
                        'label' =>  $value->name,
                        'value' =>  $value->id
                    ];
                }
            }
        }

        return response()->json($results);
    }

    public function village(Request $request)
    {
        $uri = "https://wilayah-indonesia.maisys.site/static/api/villages/$request->district_id.json";

        if ($request->village_id) {
            $uri = "https://wilayah-indonesia.maisys.site/static/api/village/$request->village_id.json";
        }

        $dataVillage = getAPI($uri);

        $results = array();

        if ($dataVillage) {
            if (collect($dataVillage)->count() == 1) {
                return response()->json($dataVillage);
            } else {
                foreach ($dataVillage as $key => $value) {
                    $results[] = [
                        'label' =>  $value->name,
                        'value' =>  $value->id
                    ];
                }
            }
        }

        return response()->json($results);
    }

    public function month()
    {
        $dataMonth = collect(Carbon::now()->startOfYear()->subMonth(12)->monthsUntil(Carbon::now()->startOfYear()))
            ->mapWithKeys(fn ($month) => [$month->month => $month->monthName]);

        $results = array();

        if ($dataMonth) {
            foreach ($dataMonth as $row => $value) {
                $results[] = [
                    'label' =>  $value,
                    'value' =>  $value
                ];
            }
        }

        return response()->json($results);
    }

    public function year()
    {
        $dataYear = collect(Carbon::now()->startOfQuarter()->subYears(30)->yearsUntil(Carbon::now()))
            ->mapWithKeys(fn ($year) => [$year->year => $year->year]);

        $results = array();

        if ($dataYear) {
            foreach ($dataYear as $row => $value) {
                $results[] = [
                    'label' =>  $value,
                    'value' =>  $row
                ];
            }
        }

        return response()->json($results);
    }

    public function agency()
    {
        $dataAgency = User::where('role_id', 2)
            ->get();

        $results = array();

        if ($dataAgency) {
            foreach ($dataAgency as $key => $value) {
                $results[]  =  [
                    'label' =>  $value->name . ' - ' . $value->country->name,
                    'value' =>  $value->id,
                ];
            }
        }

        return response()->json($results);
    }

    public function maids(Request $request)
    {
        $dataAgency = User::where('id', $request->agency)
            ->first();

        $results = array();

        if ($dataAgency) {
            $dataMaids = UserMaid::where('is_bookmark', false)
                ->where('is_uploaded', false)
                ->where('is_delete', false)
                ->where('is_taken', false)
                ->where('is_active', true)
                ->countryUser($dataAgency->country->code, $dataAgency->is_formal)
                ->get();

            if ($dataMaids) {
                foreach ($dataMaids as $key => $value) {
                    $results[]  =  [
                        'label' =>  $value->code_maid . ' - ' . $value->full_name,
                        'value' =>  $value->id,
                    ];
                }
            }
        }

        return response()->json($results);
    }
}

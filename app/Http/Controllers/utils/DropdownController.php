<?php

namespace App\Http\Controllers\utils;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Role;
use Illuminate\Http\Request;

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
        $uri = 'https://semyluase.github.io/api-indonesia/static/api/provinces.json';

        if ($request->province_id) {
            $uri = "https://semyluase.github.io/api-indonesia/static/api/province/$request->province_id.json";
        }

        $dataProvince = getAPI($uri);

        $results = array();

        if ($dataProvince) {
            if (collect($dataProvince)->count() > 1) {
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
        $uri = "https://semyluase.github.io/api-indonesia/static/api/regencies/$request->province_id.json";

        if ($request->regency_id) {
            $uri = "https://semyluase.github.io/api-indonesia/static/api/regency/$request->regency_id.json";
        }

        $dataRegency = getAPI($uri);

        $results = array();

        if ($dataRegency) {
            if (collect($dataRegency)->count() > 1) {
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
        $uri = "https://semyluase.github.io/api-indonesia/static/api/districts/$request->regency_id.json";

        if ($request->district_id) {
            $uri = "https://semyluase.github.io/api-indonesia/static/api/district/$request->district_id.json";
        }

        $dataDistrict = getAPI($uri);

        $results = array();

        if ($dataDistrict) {
            if (collect($dataDistrict)->count() > 0) {
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
        $uri = "https://semyluase.github.io/api-indonesia/static/api/villages/$request->district_id.json";

        if ($request->village_id) {
            $uri = "https://semyluase.github.io/api-indonesia/static/api/village/$request->village_id.json";
        }

        $dataVillage = getAPI($uri);

        $results = array();

        if ($dataVillage) {
            if (collect($dataVillage)->count() > 1) {
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
}

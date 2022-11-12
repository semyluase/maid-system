<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.country.index', [
            'title' =>  'User Country',
            'pageTitle' =>  'User Country',
            'js'    =>  ['assets/js/apps/master/country/app.js']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'  =>  'required',
            'name'  =>  'required',
        ], [
            'code.required' =>  "Country Code is required",
            'name.required' =>  "Country Name is required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $slug = SlugService::createSlug(Country::class, 'slug', $request->name, ['unique' => false]);

            $validator = Validator::make(['slug'    =>  $slug], [
                'slug'  =>  'unique:countries',
            ], [
                'slug.unique' =>  "This data is already exists",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  $validator->errors()
                    ]
                ]);
            } else {
                $data = [
                    'code'  =>  Str::upper($request->code),
                    'name'  =>  Str::title($request->name),
                    'slug'  =>  $slug,
                    'user_created'  =>  auth()->user()->id,
                ];

                if (Country::create($data)) {
                    return response()->json([
                        'data'  =>  [
                            'status'    =>  true,
                            'message'   =>  "Data is successfully Added"
                        ]
                    ]);
                } else {
                    return response()->json([
                        'data'  =>  [
                            'status'    =>  false,
                            'message'   =>  "Data is failed to Add"
                        ]
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return response()->json($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [
            'code'  =>  'required',
            'name'  =>  'required',
        ], [
            'code.required' =>  "Country Code is required",
            'name.required' =>  "Country Name is required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $slug = SlugService::createSlug(Country::class, 'slug', $request->name, ['unique' => false]);

            if ($slug !== $country->slug) {
                $validator = Validator::make(['slug'    =>  $slug], [
                    'slug'  =>  'unique:countries',
                ], [
                    'slug.unique' =>  "This data is already exists",
                ]);
            }

            if ($validator->fails()) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  $validator->errors()
                    ]
                ]);
            } else {
                $data = [
                    'code'  =>  Str::upper($request->code),
                    'name'  =>  Str::title($request->name),
                    'slug'  =>  $slug,
                    'user_updated'  =>  auth()->user()->id,
                ];

                if (Country::find($country->id)->update($data)) {
                    return response()->json([
                        'data'  =>  [
                            'status'    =>  true,
                            'message'   =>  "Data is successfully updated"
                        ]
                    ]);
                } else {
                    return response()->json([
                        'data'  =>  [
                            'status'    =>  false,
                            'message'   =>  "Data is failed to update"
                        ]
                    ]);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $data = [
            'is_active' => false,
            'user_updated'  =>  auth()->user()->id,
        ];

        if (Country::find($country->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Data is successfully deleted"
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  "Data is failed to delete"
                ]
            ]);
        }
    }

    public function getAllData(Request $request)
    {
        $dataCountry = Country::with(['userCreated', 'userUpdated'])
            ->filter(['search' => $request->search['value']])
            ->where('is_active', true)
            ->skip($request->start)
            ->limit($request->length == -1 ? 0 : $request->length)
            ->orderBy(columnOrder(['id', 'code', 'name', 'id', 'id'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get();

        $totalData = collect(Country::with(['userCreated', 'userUpdated'])
            ->where('is_active', true)
            ->orderBy(columnOrder(['id', 'code', 'name', 'id', 'id'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $totalFiltered = collect(Country::with(['userCreated', 'userUpdated'])
            ->filter(['search' => $request->search['value']])
            ->where('is_active', true)
            ->orderBy(columnOrder(['id', 'code', 'name', 'id', 'id'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $results = array();
        $no = $request->start + 1;

        if ($dataCountry) {
            foreach ($dataCountry as $key => $value) {
                $btnAction = '<div class="dropdown">
                                <button type="button" class="btn btn-outline-primary dropdown-content" id="dropdown-action" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-layer-group"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labeledby="dropdown-action">
                                    <li>
                                        <a href="#" class="dropdown-item" onclick="fnCountry.onEdit(\'' . $value->slug . '\')">
                                            <i class="fa-solid fa-edit me-2"></i>
                                            <span>Edit Data</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item" onclick="fnCountry.onDelete(\'' . $value->slug . '\',\'' . csrf_token() . '\')">
                                            <i class="fa-solid fa-trash me-2"></i>
                                            <span>Delete Data</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>';

                $results[]  = [
                    $no,
                    '<a href="javascript:;" onclick="fnCountry.onShow(\'' . $value->code . '\')">' . $value->code . '</a>',
                    $value->name,
                    $value->userCreated ? $value->userCreated->name : '-',
                    $value->userUpdated ? $value->userUpdated->name : '-',
                    $btnAction
                ];

                $no++;
            }
        }

        return response()->json([
            'data'  =>  $results,
            'recordsTotal'  =>  $totalData,
            'recordsFiltered'   =>  $totalFiltered,
            'draw'  =>  $request->draw
        ]);
    }
}

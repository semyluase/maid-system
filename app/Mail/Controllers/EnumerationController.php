<?php

namespace App\Http\Controllers;

use App\Models\Enumeration;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EnumerationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.enumeration.index', [
            'title' =>  'Enumeration',
            'pageTitle' =>  'Enumeration',
            'js'    =>  ['assets/js/apps/master/enumeration/app.js']
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
            'category'  =>  'required'
        ], [
            'code.required' =>  'Code field is required',
            'name.required' =>  'Name field is required',
            'category.required' =>  'Category field is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $slug = SlugService::createSlug(Enumeration::class, 'slug', $request->code . ' ' . $request->category, ['unique' => false]);

        $validator = Validator::make(['slug' => $slug], [
            'slug'  =>  'unique:enumerations',
        ], [
            'slug.unique'   =>  'This data is exists in our database'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $data = [
            'code'  =>  Str::upper($request->code),
            'name'  =>  Str::title($request->name),
            'name_hk'  =>  $request->nameHK,
            'category'  =>  Str::title($request->category),
            'slug'  =>  $slug,
            'use_for'  =>  Str::lower(Str::replace(' ', '-', $request->category)),
            'user_created'  =>  auth()->user()->id,
        ];

        $enum = Enumeration::create($data);

        if ($enum) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Data $enum->name successfully added"
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  "Data failed to add"
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enumeration  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function show(Enumeration $enumeration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enumeration  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function edit(Enumeration $enumeration)
    {
        return response()->json($enumeration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enumeration  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enumeration $enumeration)
    {
        $validator = Validator::make($request->all(), [
            'code'  =>  'required',
            'name'  =>  'required',
            'category'  =>  'required'
        ], [
            'code.required' =>  'Code field is required',
            'name.required' =>  'Name field is required',
            'category.required' =>  'Category field is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $slug = SlugService::createSlug(Enumeration::class, 'slug', $request->code . ' ' . $request->category, ['unique' => false]);

        if ($slug != $enumeration->slug) {
            $validator = Validator::make(['slug' => $slug], [
                'slug'  =>  'unique:enumerations',
            ], [
                'slug.unique'   =>  'This data is exists in our database'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $data = [
            'code'  =>  Str::upper($request->code),
            'name'  =>  Str::title($request->name),
            'name_hk'  =>  $request->nameHK,
            'category'  =>  Str::title($request->category),
            'slug'  =>  $slug,
            'use_for'  =>  Str::lower(Str::replace(' ', '-', $request->category)),
            'user_updated'  =>  auth()->user()->id,
        ];

        $enum = Enumeration::find($enumeration->id)->update($data);

        if ($enum) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Data $enumeration->name successfully updated"
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  "Data failed to update"
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enumeration  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enumeration $enumeration)
    {
        $data = [
            'is_active' =>  false,
            'user_updated'  =>  auth()->user()->id,
        ];

        $enum = Enumeration::find($enumeration->id)->update($data);

        if ($enum) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Data $enumeration->name successfully deleted"
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  "Data failed to delete"
            ]
        ]);
    }

    public function getAllData(Request $request)
    {
        $totalData = collect(Enumeration::where('is_active', true)
            ->get())->count();

        $totalFiltered = collect(Enumeration::where('is_active', true)
            ->filter(['search' => $request->search['value']])
            ->get())->count();

        $dataEnum = Enumeration::with(['userCreated', 'userUpdated'])
            ->where('is_active', true)
            ->filter(['search' => $request->search['value']])
            ->orderBy(columnOrder(['id', 'name', 'name_hk', 'category', 'id', 'id'], $request->order[0]['column']), $request->order[0]['dir'])
            ->skip($request->start)
            ->limit($request->length == -1 ? $totalData : $request->length)
            ->get();

        $results = array();
        $no = $request->start + 1;

        if ($dataEnum) {
            foreach ($dataEnum as $key => $value) {
                $btnAction = '<div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-layer-group me-2"></i>
                                    <span>Detail Action</span>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="btn-action">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="enumeration.onEdit(\'' . $value->slug . '\')"><i class="fa-solid fa-edit me-2"></i>Edit Data</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="enumeration.onDelete(\'' . $value->slug . '\',\'' . csrf_token() . '\')"><i class="fa-solid fa-trash me-2"></i>Delete Data</a></li>
                                </ul>
                            </div>';

                $results[] = [
                    $no,
                    $value->name,
                    $value->name_hk,
                    $value->category,
                    $value->userCreated ? $value->userCreated->name : '-',
                    $value->userUpdated ? $value->userUpdated->name : '-',
                    $btnAction,
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

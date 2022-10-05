<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.role.index', [
            'title' =>  'Role',
            'pageTitle' =>  'Role',
            'js'    =>  ['assets/js/apps/master/role/app.js']
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
            'name'  =>  'required',
            'description'   =>  'required'
        ], [
            'name.required' =>  'Name Role is required',
            'description.required'  =>  'Description Role is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $slug = SlugService::createSlug(Role::class, 'slug', $request->name, ['unique' => false]);

            $validator = Validator::make(['slug' => $slug], [
                'slug'  =>  'unique:roles',
            ], [
                'slug.unique'   =>  'This data is registered in our system',
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
                'name'  =>  $request->name,
                'slug'  =>  $slug,
                'description'   =>  ucwords($request->description),
                'user_created'  =>  auth()->user()->id,
            ];

            if (Role::create($data)) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data is successfully added'
                    ]
                ]);
            } else {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Data is failed to add'
                    ]
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'description'   =>  'required'
        ], [
            'name.required' =>  'Name Role is required',
            'description.required'  =>  'Description Role is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            $slug = SlugService::createSlug(Role::class, 'slug', $request->name, ['unique' => false]);

            if ($slug != $role->slug) {
                $validator = Validator::make(['slug' => $slug], [
                    'slug'  =>  'unique:roles',
                ], [
                    'slug.unique'   =>  'This data is registered in our system',
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
                'name'  =>  $request->name,
                'slug'  =>  $slug,
                'description'   =>  ucwords($request->description),
                'user_updated'  =>  auth()->user()->id,
            ];

            if (Role::find($role->id)->update($data)) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data is successfully updated'
                    ]
                ]);
            } else {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Data failed to update'
                    ]
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $data = [
            'is_active' =>  false,
            'user_updated'  =>  auth()->user()->id,
        ];

        if (Role::find($role->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data is successfully deleted'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data failed to delete'
                ]
            ]);
        }
    }

    public function getAllData()
    {
        $dataRole = Role::with(['createUser', 'updateUser'])
            ->where('is_active', true)
            ->get();

        $results = array();

        if ($dataRole) {
            foreach ($dataRole as $row => $valRole) {
                $button = '<div class="d-flex hstack gap-2">' .
                    '<a href="javascript:;" class="btn btn-outline-info" onclick="fnRole.editData(\'' . $valRole->slug . '\')"><i class="fas fa-edit"></i></a>' .
                    '<a href="javascript:;" class="btn btn-outline-danger" onclick="fnRole.deleteData(\'' . $valRole->slug . '\',\'' . csrf_token() . '\')"><i class="fas fa-times"></i></a>' .
                    '</div>';

                $userCreated = '';
                $userUpdated = '';

                if ($valRole->updateUser != null) {
                    $userUpdated = '<div>' . $valRole->updateUser->name . '</div><small class="text-muted">' . date_format($valRole->updated_at, 'd M Y H:i:s') . '</small>';
                } else {
                    $userUpdated = '-';
                }

                if ($valRole->createUser != null) {
                    $userCreated = '<div>' . $valRole->createUser->name . '</div><small class="text-muted">' . date_format($valRole->created_at, 'd M Y H:i:s') . '</small>';
                } else {
                    $userCreated = '-';
                }

                $results[] = [
                    $row + 1,
                    $valRole->name,
                    $valRole->description,
                    $userCreated,
                    $userUpdated,
                    $button,
                ];
            }
        }
        return response()->json($results);
    }
}

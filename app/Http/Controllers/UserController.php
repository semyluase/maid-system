<?php

namespace App\Http\Controllers;

use App\Models\TemplateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', [
            'title' =>  'User',
            'pageTitle' =>  'User',
            'js'    =>  ['assets/js/apps/user/app.js']
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
        Carbon::setLocale('id');

        $validator = Validator::make($request->all(), [
            'username'  =>  'required|unique:users',
            'name'  =>  'required',
            'email' =>  'required|unique:users|email:dns',
            'role'  =>  'required',
            'country'  =>  'required',
            'password'  =>  'required',
        ], [
            'username.required' =>  'Username field is required',
            'username.unique'   =>  'This username is exists',
            'name.required'  =>  'Name User field is required',
            'email.required'    =>  'User Email is required',
            'email.unique'  =>  'User with this email is exists',
            'email.email'  =>  'Wrong format',
            'role.required' =>  'Please choose User Role',
            'country.required' =>  'Please choose Country',
            'password.required' =>  'User Password is required'
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
                'username'  =>  $request->username,
                'name'  =>  ucwords($request->name),
                'email' =>  $request->email,
                'role_id'   =>  $request->role,
                'country_id'   =>  $request->country,
                'password'  =>  bcrypt($request->password)
            ];

            $user = User::create($data);
            if ($user) {
                // $template = explode(',', );

                $arrData = array();

                foreach ($request->template as $key) {
                    $arrData[] = [
                        'user_id'   =>  $user->id,
                        'template'  =>  $key,
                        'created_at'    =>  now('Asia/Jakarta')
                    ];
                }

                if (!empty($arrData)) {
                    TemplateUser::insert($arrData);
                }

                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data successfully save'
                    ]
                ]);
            } else {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Data failed to save'
                    ]
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json($user->load(['role', 'template']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = array();

        if ($request->password) {
            $data = [
                'username'  =>  $request->username,
                'name'  =>  ucwords($request->name),
                'email' =>  $request->email,
                'role_id'   =>  $request->role,
                'country_id'   =>  $request->country,
                'password'  =>  bcrypt($request->password)
            ];
        } else {
            $data = [
                'username'  =>  $request->username,
                'name'  =>  ucwords($request->name),
                'email' =>  $request->email,
                'role_id'   =>  $request->role,
                'country_id'   =>  $request->country,
            ];
        }

        if (User::find($user->id)->update($data)) {
            $arrData = array();

            foreach ($request->template as $key) {
                $arrData[] = [
                    'user_id'   =>  $user->id,
                    'template'  =>  $key,
                    'created_at'    =>  now('Asia/Jakarta')
                ];
            }

            if (!empty($arrData)) {
                $templateData = TemplateUser::where('user_id', $user->id)
                    ->get();

                if ($templateData) {
                    TemplateUser::where('user_id', $user->id)
                        ->delete();
                }

                TemplateUser::insert($arrData);
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data successfully change'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data failed to change'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        TemplateUser::where('user_id', $user->id)
            ->delete();

        if (User::destroy($user->id)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data successfully deleted'
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

    public function getAllData(Request $request)
    {
        Carbon::setLocale('id');
        $dataUser = User::with(['role'])
            ->filter(['search' => $request->search['value']])
            ->skip($request->start)
            ->limit($request->length)
            ->orderBy(columnOrder(['users.username', 'users.name', 'users.id', 'users.created_at', 'users.updated_at'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get();

        $totalData = collect(User::with(['role'])
            ->orderBy(columnOrder(['users.username', 'users.name', 'users.id', 'users.created_at', 'users.updated_at'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $totalFiltered = collect(User::with(['role'])
            ->filter(['search' => $request->search['value']])
            ->orderBy(columnOrder(['users.username', 'users.name', 'users.id', 'users.created_at', 'users.updated_at'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $results = array();

        if ($dataUser) {
            foreach ($dataUser as $row => $valUser) {
                $results[] = [
                    $valUser->username,
                    $valUser->name,
                    $valUser->role->name,
                    date_format($valUser->created_at, 'd M Y H:i:s'),
                    date_format($valUser->updated_at, 'd M Y H:i:s'),
                    '<div class="d-flex hstack gap-3">
                        <a href="javascript:;" class="btn btn-outline-info" onclick="user.editData(\'' . $valUser->username . '\')"><i class="fas fa-edit"></i></a>
                        <a href="javascript:;" class="btn btn-outline-danger" onclick="user.deleteData(\'' . $valUser->username . '\',\'' . csrf_token() . '\')"><i class="fas fa-times"></i></a>
                    </div>'
                ];
            }
        }
        return response()->json([
            'data'  =>  $results,
            'recordsTotal'  =>  $totalData,
            'recordsFiltered'   =>  $totalFiltered,
            'draw'  =>  $request->draw
        ]);
    }

    public function myProfile()
    {
        return view('manage.profile.index', [
            'title' =>  'My Profile',
            'pageTitle' =>  'My Profile',
            'js'    =>  ['assets/js/apps/manage/profile/app.js']
        ]);
    }

    public function updateProfile(Request $request, User $user)
    {
        $data = [
            'name'  =>  ucwords($request->name),
            'email' =>  $request->email
        ];

        if (User::find($user->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data successfully change'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data failed to change'
                ]
            ]);
        }
    }

    public function changePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword'   =>  'required',
            'newPassword'   =>  'required',
            'confirmPassword'   =>  'required'
        ], [
            'oldPassword.required'  =>  'Old Password is required',
            'newPassword.required'  =>  'New Password is required',
            'confirmPassword.required'  =>  'Confirm Password is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        } else {
            if (!Hash::check($request->oldPassword, $user->password)) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Old Password is not match'
                    ]
                ]);
            }

            if ($request->newPassword !== $request->confirmPassword) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'New Password & Confirm Password is not match'
                    ]
                ]);
            }

            if (!Hash::check($request->newPassword, $user->password)) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'New Password cannot same with Old Password'
                    ]
                ]);
            }

            $data = [
                'password'  =>  bcrypt($request->newPassword)
            ];

            if (User::find($user->id)->update($data)) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Password is successfully change'
                    ]
                ]);
            } else {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Password failed to change'
                    ]
                ]);
            }
        }
    }
}

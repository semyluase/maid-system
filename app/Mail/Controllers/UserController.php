<?php

namespace App\Http\Controllers;

use App\Models\TemplateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
            'email' =>  'required|email:dns',
            'role'  =>  'required',
            'country'  =>  'required',
            'password'  =>  'required',
        ], [
            'username.required' =>  'Username field is required',
            'username.unique'   =>  'This username is exists',
            'name.required'  =>  'Name User field is required',
            'email.required'    =>  'User Email is required',
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
                'password'  =>  bcrypt($request->password),
                'is_formal'  =>  $request->formal ? $request->formal : false,
            ];

            $user = User::create($data);
            if ($user) {
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
        return response()->json($user->load(['role']));
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
                'password'  =>  bcrypt($request->password),
                'is_formal'  =>  $user->role_id == 2 ? ($request->formal ? $request->formal : false) : false,
            ];
        } else {
            $data = [
                'username'  =>  $request->username,
                'name'  =>  ucwords($request->name),
                'email' =>  $request->email,
                'role_id'   =>  $request->role,
                'country_id'   =>  $request->country,
                'is_formal'  =>  $user->role_id == 2 ? ($request->formal ? $request->formal : false) : false,
            ];
        }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (User::find($user->id)->update([
            'is_locked' =>  $user->is_locked ? false : true,
        ])) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  $user->is_locked ? 'Data successfully locked' : 'Data successfully unlocked'
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data failed to lock'
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
                $btnAction = '<div class="d-flex hstack gap-3">
                                <a href="javascript:;" class="btn btn-outline-info" onclick="user.editData(\'' . $valUser->username . '\')"><i class="fas fa-edit"></i></a>';
                if ($valUser->is_locked) {
                    $btnAction .= '<a href="javascript:;" class="btn btn-outline-success" onclick="user.deleteData(\'' . $valUser->username . '\',\'' . csrf_token() . '\')"><i class="fas fa-key"></i></a>';
                } else {
                    $btnAction .= '<a href="javascript:;" class="btn btn-outline-danger" onclick="user.deleteData(\'' . $valUser->username . '\',\'' . csrf_token() . '\')"><i class="fas fa-key"></i></a>';
                }

                $btnAction .= '</div>';
                $results[] = [
                    $valUser->username,
                    $valUser->name,
                    $valUser->role->name,
                    $valUser->is_locked ? '<span class="badge bg-danger px-3 py-2">Locked</span>' : '<span class="badge bg-success px-3 py-2">Active</span>',
                    date_format($valUser->created_at, 'd M Y H:i:s'),
                    date_format($valUser->updated_at, 'd M Y H:i:s'),
                    $btnAction,
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
        if (auth()->user()->role_id == 2) {
            return view('manage.profile.userIndex', [
                'title' =>  'My Profile',
                'pageTitle' =>  'My Profile',
                'js'    =>  ['assets/js/apps/manage/profile/app.js']
            ]);
        }

        return view('manage.profile.index', [
            'title' =>  'My Profile',
            'pageTitle' =>  'My Profile',
            'js'    =>  ['assets/js/apps/manage/profile/app.js']
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        $filename = $user->username;
        if ($request->file('profilePictureFile')) {
            $dataAvatar = $request->file('profilePictureFile');

            $filename = $filename . '.' . $dataAvatar->getClientOriginalExtension();

            if ($user->image != 'default.jpg') {
                File::delete(public_path('assets/image/user/' . $user->image));
            }
            $dataAvatar->move(public_path('assets/image/user'), $filename);
        }

        $data = [
            'name'  =>  ucwords($request->profilName),
            'email' =>  $request->profileEmail,
            'about_me'  =>  Str::title($request->aboutMe),
            'image' =>  $request->file('profilePictureFile') ? $filename : 'default.jpg',
        ];

        if ($request->oldPassword != "") {
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

                if (Hash::check($request->newPassword, $user->password)) {
                    return response()->json([
                        'data'  =>  [
                            'status'    =>  false,
                            'message'   =>  'New Password cannot same with Old Password'
                        ]
                    ]);
                }

                $data['password'] = bcrypt($request->newPassword);
            }
        }

        if (User::where('username', $user->username)->update($data)) {
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

    public function getProfile(User $user)
    {
        return response()->json($user);
    }
}

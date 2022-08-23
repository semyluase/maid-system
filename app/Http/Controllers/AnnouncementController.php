<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.announcement.index', [
            'title' =>  'Announcement',
            'pageTitle' =>  'Announcement',
            'js'    =>  ['assets/js/apps/master/announcement/app.js']
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
            'title' =>  'required',
            'body'  =>  'required',
        ], [
            'title.required'    =>  'Title field is Required',
            'body.required' =>  'Body is Required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $slug = SlugService::createSlug(Announcement::class, 'slug', $request->title);

        $data = [
            'title' =>  Str::title($request->title),
            'body'  =>  $request->body,
            'slug'  =>  $slug,
            'date_start'    =>  $request->dateStart,
            'date_end'    =>  $request->dateEnd,
            'user_created'  =>  auth()->user()->id,
        ];

        if (Announcement::create($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data Announcement successfully added'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data Announcement failed add'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return response()->json($announcement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' =>  'required',
            'body'  =>  'required',
        ], [
            'title.required'    =>  'Title field is Required',
            'body.required' =>  'Body is Required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $slug = '';

        if (Str::lower($request->title) != Str::lower($announcement->title)) {
            $slug = SlugService::createSlug(Announcement::class, 'slug', $request->title);
        }

        $data = [
            'title' =>  Str::title($request->title),
            'body'  =>  $request->body,
            'slug'  =>  $slug == '' ? $announcement->slug : $slug,
            'date_start'    =>  $request->dateStart,
            'date_end'    =>  $request->dateEnd,
            'user_updated'  =>  auth()->user()->id,
        ];

        if (Announcement::find($announcement->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data Announcement successfully updated'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data Announcement failed update'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $data = [
            'is_active' =>  false,
            'user_updated'  =>  auth()->user()->id,
        ];

        if (Announcement::find($announcement->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data Announcement successfully deleted'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data Announcement failed delete'
            ]
        ]);
    }

    public function getAllData(Request $request)
    {
        Carbon::setLocale('id');
        $totalData = collect(Announcement::where('date_start', '>=', Carbon::now()->isoFormat("YYYY-MM-DD"))
            ->where('is_active', true)
            ->orderBy(columnOrder(['id', 'title'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $totalFiltered = collect(Announcement::where('date_start', '>=', Carbon::now()->isoFormat("YYYY-MM-DD"))
            ->where('is_active', true)
            ->filter(['search' => $request->search['value']])
            ->orderBy(columnOrder(['id', 'title'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $dataAnnouncement = Announcement::with(['userCreated', 'userUpdated'])
            ->where('date_start', '>=', Carbon::now()->isoFormat("YYYY-MM-DD"))
            ->where('is_active', true)
            ->filter(['search' => $request->search['value']])
            ->skip($request->start)
            ->limit($request->length == -1 ? $totalData : $request->length)
            ->orderBy(columnOrder(['id', 'title'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get();

        $results = array();
        $no = $request->start + 1;

        if ($dataAnnouncement) {
            foreach ($dataAnnouncement as $key => $value) {
                $btnAction = '<div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdown-menu-detail" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-layer-group me-2"></i>Details
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-menu-detail">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="fnAnnouncement.onEdit(\'' . $value->slug . '\')"><i class="fa-solid fa-edit me-2"></i>Edit Data</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="fnAnnouncement.onDelete(\'' . $value->slug . '\',\'' . csrf_token() . '\')"><i class="fa-solid fa-trash me-2"></i>Delete Data</a></li>
                                </ul>
                            </div>';

                $results[] = [
                    $no,
                    $value->title,
                    Carbon::parse($value->date_end)->diffInDays(Carbon::parse($value->date_start)) + 1 . ' Days',
                    $value->userCreated ? $value->userCreated->name : '',
                    $value->userUpdated ? $value->userUpdated->name : '',
                    $btnAction,
                ];

                $no++;
            }
        }

        return response()->json([
            'data'  =>  $results,
            'recordsTotal'  =>  $totalData,
            'recordsFiltered'   =>  $totalFiltered,
            'draw'  =>  $request->draw,
        ]);
    }
}

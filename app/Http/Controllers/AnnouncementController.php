<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ConcactPerson;
use App\Models\ContactPerson;
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
        $dataAnnouncement = Announcement::latest()->first();
        return view('master.announcement.index', [
            'title' =>  'Announcement',
            'pageTitle' =>  'Announcement',
            'announcement'  =>  $dataAnnouncement,
            'js'    =>  ['assets/mazer/dist/assets/vendors/quill/quill.min.js', 'assets/js/apps/master/announcement/app.js']
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
        if ($request->type == 'announcement') {
            $dataAnnouncement = Announcement::latest()->first();

            $data = [
                'body'  =>  $request->body,
                'user_created'  =>  auth()->user()->id,
                'user_updated'  =>  auth()->user()->id,
            ];

            if (Announcement::find($dataAnnouncement->id)->update($data)) {
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
                    'message'   =>  'Data Announcement failed updated'
                ]
            ]);
        }

        if ($request->type == 'contact') {
            $data = [
                'name'  =>  $request->name,
                'branch'  =>  $request->branch,
                'whatsapp'  =>  $request->whatsapp,
                'code'  =>  $request->code,
                'user_created'  =>  auth()->user()->id,
            ];

            if (ContactPerson::create($data)) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data Contact Person successfully added'
                    ]
                ]);
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data Contact Person failed added'
                ]
            ]);
        }
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
    public function edit(ContactPerson $announcement)
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
    public function update(Request $request, ContactPerson $announcement)
    {
        $data = [
            'name'  =>  $request->name,
            'branch'  =>  $request->branch,
            'whatsapp'  =>  $request->whatsapp,
            'code'  =>  $request->code,
            'user_updated'  =>  auth()->user()->id,
        ];

        if (ContactPerson::find($announcement->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data Contact Person successfully updated'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data Contact Person failed update'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactPerson $announcement)
    {
        if (ContactPerson::find($announcement->id)->delete()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data Contact Person successfully deleted'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data Contact Person failed delete'
            ]
        ]);
    }

    public function getAllData(Request $request)
    {
        Carbon::setLocale('id');
        $totalData = collect(ContactPerson::orderBy(columnOrder(['id', 'name', 'branch', 'whatsapp', 'code'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $totalFiltered = collect(ContactPerson::filter(['search' => $request->search['value']])
            ->orderBy(columnOrder(['id', 'name', 'branch', 'whatsapp', 'code'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get())->count();

        $dataContactPerson = ContactPerson::filter(['search' => $request->search['value']])
            ->skip($request->start)
            ->limit($request->length == -1 ? $totalData : $request->length)
            ->orderBy(columnOrder(['id', 'name', 'branch', 'whatsapp', 'code'], $request->order[0]['column']), $request->order[0]['dir'])
            ->get();

        $results = array();
        $no = $request->start + 1;

        if ($dataContactPerson) {
            foreach ($dataContactPerson as $key => $value) {
                $btnAction = '<div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdown-menu-detail" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-layer-group me-2"></i>Details
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-menu-detail">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="fnAnnouncement.onEdit(\'' . $value->id . '\')"><i class="fa-solid fa-edit me-2"></i>Edit Data</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="fnAnnouncement.onDelete(\'' . $value->id . '\',\'' . csrf_token() . '\')"><i class="fa-solid fa-trash me-2"></i>Delete Data</a></li>
                                </ul>
                            </div>';

                $results[] = [
                    $no,
                    $value->name,
                    $value->branch,
                    $value->whatsapp,
                    $value->code,
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

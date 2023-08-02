<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use App\Models\Master\Maid\Maid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('history.maid.index', [
            'title' =>  'History Maid Data',
            'pageTitle' =>  'History Maid Data',
            'js'    =>  ['assets/js/apps/history/maid/app.js'],
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master\Maid\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function show(Maid $maid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Maid\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function edit(Maid $maid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Maid\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maid $maid)
    {
        $data = [
            'is_trash'    =>  false,
            'user_trashed'  =>  null,
            'trashed_at'    =>  null,
        ];

        if (Maid::find($maid->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data successfully reactivated!'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data failed to reactivate!'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Maid\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maid $maid)
    {
        $data = [
            'is_delete'    =>  true,
            'is_trash'    =>  false,
            'user_delete'  =>  auth()->user()->id,
            'deleted_at'    =>  Carbon::now('Asia/Jakarta'),
        ];

        if (Maid::destroy($maid->id)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data successfully permanent delete!'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data failed to permanent delete!'
            ]
        ]);
    }

    public function getAllData(Request $request)
    {
        $totalData = collect(Maid::where('is_active', true)
            ->where('is_trash', true)
            ->get())->count();

        $filteredData = collect(Maid::where('is_active', true)
            ->where('is_trash', true)
            ->filter([
                'search' => $request->search['value'],
                'code'  =>  $request->code,
                'name'  =>  $request->name,
                'start_age'  =>  $request->start_age,
                'end_age'  =>  $request->end_age,
                'education'  =>  $request->education,
                'marital'  =>  $request->marital,
            ], $request->country)
            ->get())->count();

        $maidData = Maid::with(['userTrashed'])
            ->where('is_active', true)
            ->where('is_trash', true)
            ->filter([
                'search' => $request->search['value'],
                'code'  =>  $request->code,
                'name'  =>  $request->name,
                'start_age'  =>  $request->start_age,
                'end_age'  =>  $request->end_age,
                'education'  =>  $request->education,
                'marital'  =>  $request->marital,
            ], $request->country)
            ->skip($request->start)
            ->limit($request->length)
            ->get();

        $results = array();
        $no = $request->start + 1;

        if ($maidData) {
            foreach ($maidData as $key => $value) {
                $country = '';

                if ($value->is_hongkong) $country = "Hongkong";
                if ($value->is_taiwan) $country = "Taiwan";
                if ($value->is_malaysia) $country = "Malaysia";
                if ($value->is_singapore) $country = "Singapore";
                if ($value->is_brunei) $country = "Brunei";
                if ($value->is_all_format) $country = "All Format";

                $results[] = [
                    $no,
                    $value->code_maid,
                    $value->full_name,
                    $country,
                    $value->userTrashed ? $value->userTrashed->name : '',
                    Carbon::parse($value->trashed_at)->isoFormat('DD MMMM YYYY'),
                    '<div class="flex gap-3">
                        <a class="btn btn-outline-success" onclick="fnHistoryMaid.reactivateData(\'' . $value->code_maid . '\',\'' . csrf_token() . '\')"><i class="fa-solid fa-check"></i></a>
                        <a class="btn btn-outline-danger" onclick="fnHistoryMaid.deleteData(\'' . $value->code_maid . '\',\'' . csrf_token() . '\')"><i class="fa-solid fa-trash"></i></a>
                    </div>'
                ];

                $no++;
            }
        }

        return response()->json([
            'recordsTotal'  =>  $totalData,
            'recordsFiltered'   =>  $filteredData,
            'draw'  =>  $request->draw,
            'data'  =>  $results,
        ]);
    }
}

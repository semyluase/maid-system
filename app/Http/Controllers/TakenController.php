<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\MaidResource;
use App\Models\Master\Maid\Maid;
use App\Models\User\HistoryTakenMaid;
use Illuminate\Http\Request;

class TakenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataMaid = new MaidResource(Maid::with(['userCreated', 'userUpdated', 'historyAction', 'workExperience', 'userTaken'])
            ->where('is_active', true)
            ->where('is_trash', false)
            ->where('is_blacklist', false)
            ->where('is_delete', false)
            ->where('is_taken', true)
            ->where('code_maid', '<>', '')
            ->latest()
            ->filter([
                'search' => request('search'),
                'code'  =>  request('code'),
                'name'  =>  request('name'),
                'start_age'  =>  request('start_age'),
                'end_age'  =>  request('end_age'),
                'education'  =>  request('education'),
                'marital'  =>  request('marital'),
                'category'  =>  request('category'),
                'branch'  =>  request('branch'),
            ], request('countries'))
            ->country(request('country'))
            ->country(request('countries'))
            ->paginate(50)->withQueryString());

        return view('taken.maid.index', [
            'title' =>  'Taken Worker Data',
            'pageTitle' =>  'Taken Worker Data',
            'js'    =>  ['assets/js/apps/taken/maid/app.js'],
            'maids'  =>  $dataMaid,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Maid::where('code_maid', $id)->update([
            'is_taken'  =>  false,
            'is_uploaded'   =>  false,
            'is_approved'   =>  false,
            'user_uploaded' =>  null,
            'user_taken'    =>  null,
            'user_approved' =>  null,
            'uploaded_at'   =>  null,
            'apporoved_at'   =>  null,
            'taken_at'  =>  null,
        ])) {
            $dataMaid = Maid::where('code_maid', $id)->first();
            HistoryTakenMaid::where('maid_id', $dataMaid->id)->delete();

            return redirect('/taken/maids')->with('success', 'Success Canceled Transaction');
        }

        return redirect('/taken/maids')->with('alert', 'Failed Canceled Transaction');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

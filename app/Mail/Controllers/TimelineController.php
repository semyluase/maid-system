<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\MaidResource;
use App\Models\Master\Maid\Maid;
use App\Models\User\HistoryTakenMaid;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $dataMaid = Maid::where('code_maid', $request->maid)
            ->first();

        $dataHistory = null;

        if ($dataMaid) {
            $dataHistory = new MaidResource(HistoryTakenMaid::where('maid_id', $dataMaid->id)
                ->get());
        }

        if (auth()->user()->role->slug == 'agency') {
            return view('timeline.maid.userIndex', [
                'title' =>  'Activities',
                'pageTitle' =>  'Activities',
                'histories' =>  $dataHistory,
                'maid' =>  $dataMaid,
                'js'    =>  ['assets/js/apps/timeline/maid/userApp.js']
            ]);
        }

        return view('timeline.maid.index', [
            'title' =>  'Activities',
            'pageTitle' =>  'Activities',
            'histories' =>  $dataHistory,
            'maid' =>  $dataMaid,
            'js'    =>  ['assets/js/apps/timeline/maid/app.js']
        ]);
    }
}

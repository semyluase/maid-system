<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\MaidResource;
use App\Models\Master\Maid\Maid;
use App\Models\User\HistoryTakenMaid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $dataMaid = new MaidResource(Maid::where('is_bookmark', true)
            ->where('is_taken', false)
            ->where('is_active', true)
            ->latest()
            ->country($request->country)
            ->filter(['search' => $request->search])
            ->paginate(9));

        return view('booking.index', [
            'title' =>  'Booking Worker',
            'pageTitle' =>  'Booking Worker',
            'maids' =>  $dataMaid,
            'js'    =>  ['assets/js/apps/booking/maid/app.js']
        ]);
    }

    public function create()
    {
        return view('booking.create', [
            'title' =>  'Booking Worker',
            'pageTitle' =>  'Booking Worker',
            'js'    =>  ['assets/js/apps/booking/maid/create.js']
        ]);
    }

    public function store(Request $request)
    {
        $data = 0;
        foreach ($request->maids as $key => $value) {
            $data += Maid::where('id', $value)->update([
                'is_bookmark'   =>  true,
                'user_bookmark' =>  $request->agency,
                'bookmark_at'   =>  Carbon::now('Asia/Jakarta'),
                'bookmark_max_at'   =>  Carbon::now('Asia/Jakarta')->addDays($request->days)
            ]);

            $dataMaid = Maid::where('id', $value)->first();

            HistoryTakenMaid::create([
                'maid_id'   =>  $value,
                'date_action'   =>  Carbon::now('Asia/Jakarta'),
                'type_action'   =>  'booked',
                'message'   =>  'Booking worker ' . $dataMaid->code_maid . ' till ' . Carbon::now('Asia/Jakarta')->addDays($request->days)->isoFormat("DD MMMM YYYY"),
                'user_action'   =>  auth()->user()->id,
            ]);
        }

        if ($data > 0) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success booking worker'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed booking worker'
            ]
        ]);
    }

    public function destroy(Maid $maid)
    {
        Maid::find($maid->id)->update([
            'is_bookmark'   =>  false,
            'user_bookmark' =>  null,
            'bookmark_at'   =>  null,
            'bookmark_max_at'   =>  null
        ]);

        HistoryTakenMaid::create([
            'maid_id'   =>  $maid->id,
            'date_action'   =>  Carbon::now('Asia/Jakarta'),
            'type_action'   =>  'canceled book',
            'message'   =>  'Booking Cancel',
            'user_action'   =>  auth()->user()->id,
        ]);

        return redirect('/booked/maids');
    }
}

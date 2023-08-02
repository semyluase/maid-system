<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\MaidResource;
use App\Models\Master\Maid\Maid;
use App\Models\Notification;
use App\Models\User\HistoryTakenMaid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $dataMaid = new MaidResource(Maid::where('is_bookmark', true)
            ->where('is_active', true)
            ->where('code_maid', '<>', '')
            ->latest()
            ->country($request->country)
            ->country($request->countries)
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
            ->paginate(50)->withQueryString());

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

            Notification::create([
                'tanggal' => Carbon::now('Asia/Jakarta'),
                'message'   =>  $dataMaid->code_maid . ' - ' . $dataMaid->full_name . " Has Hold to you, please upload JO before " . Carbon::now('Asia/Jakarta')->addDays($request->days)->isoFormat("DD MMMM YYYY"),
                'type'  =>  "Hold",
                'from_user' =>  auth()->user()->id,
                'to_user'   =>  $request->agency,
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

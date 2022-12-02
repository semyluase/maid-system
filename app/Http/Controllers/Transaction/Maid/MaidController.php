<?php

namespace App\Http\Controllers\Transaction\Maid;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\MaidResource;
use App\Mail\ApprovalMail;
use App\Models\Master\Maid\Maid;
use App\Models\Notification;
use App\Models\Report\Taken;
use App\Models\User;
use App\Models\User\Document;
use App\Models\User\HistoryTakenMaid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use ZipArchive;

class MaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataMaid = new MaidResource(Maid::where('is_uploaded', true)
            ->where('is_taken', false)
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
            ])
            ->paginate(50));

        return view('transaction.maid.index', [
            'title' =>  'Transaction Maid',
            'pageTitle' =>  'Transaction Maid',
            'maids' =>  $dataMaid,
            'js'    =>  ['assets/js/apps/transaction/maid/app.js']
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
        return response()->json($maid);
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
        if ($request->type == 'accept') {
            if (Maid::find($maid->id)->update([
                'is_taken'  =>  true,
                'is_approved'  =>  true,
                'is_bookmark'   =>  false,
                'is_uploaded'   =>  false,
                'user_taken'    =>  $maid->user_uploaded,
                'user_approved'   =>  auth()->user()->id,
                'apporoved_at' =>  Carbon::now('Asia/Jakarta'),
                'taken_at' =>  Carbon::now('Asia/Jakarta'),
            ])) {
                Notification::create([
                    'message'   =>  auth()->user()->name . ' has approved ' . $maid->code_maid . ' to ' . $maid->userUploaded->name,
                    'from_user' =>  auth()->user()->id,
                    'to_user'   =>  $maid->user_uploaded,
                ]);

                HistoryTakenMaid::create([
                    'maid_id'   =>  $maid->id,
                    'date_action'   =>  Carbon::now('Asia/Jakarta'),
                    'type_action'   =>  "approved",
                    'message'   =>  auth()->user()->name . ' has approved ' . $maid->code_maid . ' to ' . $maid->userUploaded->name,
                    'user_action'   =>  auth()->user()->id,
                ]);

                Taken::create([
                    'maid_id'   =>  $maid->id,
                    'user_id'   =>  $maid->user_uploaded,
                    'taken_at'  =>  Carbon::now('Asia/Jakarta'),
                ]);

                $agency = User::where('id', $maid->user_uploaded)->first();
                Mail::to($agency->email)->send(new ApprovalMail([
                    'title' =>  "Approval Status $request->maidCode",
                    'codeMaid'  =>  $request->maidCode,
                    'user'    =>  auth()->user()->name,
                    'status'    =>  "ACCEPTED",
                ]));

                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data success to approved'
                    ]
                ]);
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data fail to approved'
                ]
            ]);
        }

        if ($request->type == 'reject') {
            if (Maid::find($maid->id)->update([
                'is_uploaded'  =>  false,
                'user_uploaded'    =>  null,
                'uploaded_at' =>  null,
            ])) {
                Notification::create([
                    'message'   =>  auth()->user()->name . ' has rejected ' . $maid->code_maid . ' to please booking or upload the valid data',
                    'from_user' =>  auth()->user()->id,
                    'to_user'   =>  $maid->user_uploaded,
                ]);

                HistoryTakenMaid::create([
                    'maid_id'   =>  $maid->id,
                    'date_action'   =>  Carbon::now('Asia/Jakarta'),
                    'type_action'   =>  "rejected",
                    'message'   =>  auth()->user()->name . ' has rejected ' . $maid->code_maid . ' to please booking or upload the valid data',
                    'user_action'   =>  auth()->user()->id,
                ]);

                $mailData = [
                    'title' =>  "Approval Status $request->maidCode",
                    'codeMaid'  =>  $request->maidCode,
                    'user'    =>  auth()->user()->name,
                    'status'    =>  "REJECTED",
                ];

                $agency = User::where('id', $maid->user_uploaded)->first();
                Mail::to($agency->email)->send(new ApprovalMail($mailData));

                return response()->json([
                    'data'  =>  [
                        'status'    =>  true,
                        'message'   =>  'Data success to rejected'
                    ]
                ]);
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data fail to rejected'
                ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Maid\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maid $maid)
    {
        //
    }

    public function document(Request $request, $document)
    {
        $dataMaid = Maid::where('code_maid', $document)
            ->first();

        $dataDocument = Document::where('maid_id', $dataMaid->id)
            ->get();

        return view('transaction.maid.document', [
            'title' =>  'Uploaded Document',
            'pageTitle' =>  'Uploaded Document',
            'documents' =>  $dataDocument,
            'maid'  =>  $dataMaid,
            'js'    =>  ['assets/js/apps/transaction/maid/document.js']
        ]);
    }

    public function download(Request $request)
    {
        // $zip = new ZipArchive;

        // $fileNameZip = 'JO-' . $request->maids . '.zip';
        $dataMaid = Maid::where('code_maid', $request->maids)
            ->first();

        $document = Document::where('maid_id', $dataMaid->id)
            ->first();

        return response()->download($_SERVER['DOCUMENT_ROOT'] . $document->doc_location . $document->doc_filename, $document->doc_filename);
    }
}

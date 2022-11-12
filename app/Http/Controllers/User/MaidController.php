<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\MaidResource;
use App\Mail\BookmarkMail;
use App\Mail\UploadedMail;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User\Document;
use App\Models\User\HistoryTakenMaid;
use App\Models\User\Maid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class MaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataMaid = new MaidResource(Maid::with(['workExperience'])
            ->where('is_active', true)
            ->where('is_trash', false)
            ->where('is_delete', false)
            ->where('is_bookmark', false)
            ->where('is_uploaded', false)
            ->where('is_taken', false)
            ->countryUser(auth()->user()->country->code, auth()->user()->is_formal)
            ->filter(['search' => $request->search])
            ->paginate(20));

        return view('userResource.maid.index', [
            'title' =>  'All Worker',
            'pageTitle' =>  'All Worker',
            'maids' =>  $dataMaid,
            'js'    =>  ['assets/js/apps/userResource/maid/app.js']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $dataMaid = Maid::where('code_maid', $request->worker)
            ->first();

        return view('userResource.maid.bookmark', [
            'title' =>  'Worker ' . $dataMaid->code_maid,
            'pageTitle' =>  'Worker ' . $dataMaid->code_maid,
            'maid' =>  $dataMaid,
            'js'    =>  ['assets/js/apps/userResource/maid/bookmark.js']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataDoc = array();
        if ($request->file('uploadDoc')) {
            $docMaid = $request->file('uploadDoc');

            foreach ($docMaid as $key => $value) {
                $fileNameFull = $request->maidCode . '-' . $key + 1 . '.' . $value->getClientOriginalExtension();
                $fileBase = str_replace('data:image/' . $value->getClientOriginalExtension() . ';base64,', '', $value);
                $fileBase = str_replace(' ', '+', $value);

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . '/assets/image/maids/documents/' . $fileNameFull)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . '/assets/image/maids/documents/' . $fileNameFull);
                }

                $value->move($_SERVER['DOCUMENT_ROOT'] . '/assets/image/maids/documents/', $fileNameFull);

                $dataDoc[] = [
                    'maid_id'   =>  columnToID('maid', 'code_maid', $request->maidCode)->id,
                    'doc_location'  =>  '/assets/image/maids/documents/',
                    'doc_base64'    =>  $fileBase,
                    'doc_filename'  =>  $fileNameFull,
                    'user_created'  =>  auth()->user()->id,
                    'created_at'    =>  Carbon::now('Asia/Jakarta'),
                    'updated_at'    =>  Carbon::now('Asia/Jakarta'),
                ];
            }

            $docs = Document::where('maid_id', columnToID('maid', 'code_maid', $request->maidCode)->id)
                ->get();

            if ($docs) {
                Document::where('maid_id', columnToID('maid', 'code_maid', $request->maidCode)->id)
                    ->delete();
            }
        }

        if (collect($dataDoc)->count() > 0) {
            Document::insert($dataDoc);
        }

        if (Maid::find(columnToID('maid', 'code_maid', $request->maidCode)->id)->update([
            'is_uploaded'   =>  true,
            'is_bookmark'   =>  false,
            'user_bookmark'   =>  null,
            'user_uploaded' =>  auth()->user()->id,
            'uploaded_at'   =>  Carbon::now('Asia/Jakarta'),
            'bookmark_at'   =>  null,
            'bookmark_max_at'   =>  null,
        ])) {
            Notification::create([
                'message'   =>  'Agency ' . auth()->user()->country->name . ' has upload worker document ',
                'from_user' =>  auth()->user()->id,
                'to_role'   =>  Role::where('slug', 'super-admin')->first()->id,
            ]);

            HistoryTakenMaid::create([
                'maid_id'   =>  columnToID('maid', 'code_maid', $request->maidCode)->id,
                'date_action'   =>  Carbon::now('Asia/Jakarta'),
                'type_action'   =>  'uploaded',
                'message'   =>  'Upload Docs for worker ' . $request->maidCode,
                'user_action'   =>  auth()->user()->id,
            ]);

            Mail::to('gmb.backoffice@gmail.com')->send(new UploadedMail([
                'title' =>  "Uploaded $request->maidCode Document",
                'codeMaid'  =>  $request->maidCode,
                'agency'    =>  auth()->user()->name,
            ]));

            return redirect('/workers')->with('message', 'Worker Document success to uploaded');
        }

        return redirect('/workers')->with('message', 'Failed to Uploading Document');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function show(Maid $maid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Maid  $maid
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
     * @param  \App\Models\User\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maid $maid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maid $maid)
    {
        //
    }
}

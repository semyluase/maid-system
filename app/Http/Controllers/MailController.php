<?php

namespace App\Http\Controllers;

use App\Mail\BroadcastWorker;
use App\Models\EmailSending;
use App\Models\Master\Maid\Maid;
use App\Models\Master\Maid\WorkExperience;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataMaid = Maid::where('code_maid', $request->maid)
            ->first();

        return view('mail.index', [
            'title' =>  'Available Worker',
            'pageTitle' =>  'Available Worker',
            'maid'  =>  $dataMaid,
            'country'   =>  $request->country,
            'js'    =>  ['assets/js/apps/mail/app.js']
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
        $dataMaid = Maid::where('code_maid', $request->codeMaid)->first();

        EmailSending::create([
            'email' =>  $request->agency,
            'maid_id'   =>  $dataMaid->id,
            'file_attachment'   =>  public_path('/assets/pdf/' . $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf'),
            'mail_fragment' =>  'BroadcastWorker',
            'maid'  => $dataMaid->code_maid,
            'files' =>  public_path('/assets/pdf/' . $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf'),
            'title' =>  "Available Maid",
        ]);

        return redirect('master/maids');
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
        //
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

<?php

namespace App\Console\Commands;

use App\Mail\ApprovalMail;
use App\Mail\BroadcastWorker;
use App\Mail\UploadedMail;
use App\Models\EmailSending;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutosendingMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailing:sending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Sending Mail By System';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dataEmail = EmailSending::where('is_blast', false)
            ->where('is_send', false)
            ->get();

        if ($dataEmail) {
            foreach ($dataEmail as $key => $value) {
                switch ($value->mail_fragment) {
                    case 'BroadcastWorker':
                        $mailData = [
                            'maid'  =>  $value->maid,
                            'files' =>  $value->file_attachment,
                            'title' =>  $value->title,
                        ];

                        Mail::to($value->email)->send(new BroadcastWorker($mailData));

                        EmailSending::where('id', $value->id)
                            ->update([
                                'is_send'   =>  true,
                            ]);
                        break;

                    case 'UploadedWorker':
                        $mailData = [
                            'agency'  =>  $value->agency,
                            'codeMaid'  =>  $value->codeMaid,
                            'files' =>  $value->file_attachment,
                            'title' =>  $value->title,
                        ];

                        Mail::to($value->email)->send(new UploadedMail($mailData));

                        EmailSending::where('id', $value->id)
                            ->update([
                                'is_send'   =>  true,
                            ]);
                        break;
                }
            }
        }
    }
}

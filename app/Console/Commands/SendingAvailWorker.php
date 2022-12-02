<?php

namespace App\Console\Commands;

use App\Mail\AllAvailable;
use App\Models\EmailSending;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendingAvailWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workers:available';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending available worker to agency email';

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
        $dataEmail = EmailSending::where('is_blast', true)
            ->where('is_send', false)
            ->get();

        if ($dataEmail) {
            foreach ($dataEmail as $key => $value) {
                $mailData = [
                    'title' =>  $value->title,
                    'files' =>  json_decode($value->files_all),
                    'maid'  =>  json_decode($value->maid_all)
                ];

                Mail::to($value->email)->send(new AllAvailable($mailData));

                EmailSending::find($value->id)->update(['is_send' => true]);

                $this->info("Success Send Email");
            }
        }

        $this->info("Email null");
    }
}

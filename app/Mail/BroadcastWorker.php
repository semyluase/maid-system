<?php

namespace App\Mail;

use App\Models\Master\Maid\WorkExperience;
use App\Models\Question;
use App\Models\User\Maid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class BroadcastWorker extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Available Worker')->view('email.broadcast')->attach(public_path($this->mailData['files']));
    }
}

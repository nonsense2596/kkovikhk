<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CallToVote extends Mailable
{
    use Queueable, SerializesModels;

    private $mailsubject;
    private $mailbody;
    private $displayName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailsubject,$mailbody,$displayName)
    {
        //
        $this->mailsubject = $mailsubject;
        $this->mailbody = $mailbody;
        $this->displayName = $displayName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->mailsubject)
            ->view('emails.calltovote')
            ->with([
                'mailbody' => $this->mailbody,
                'displayName' => $this->displayName,
            ]);
    }
}

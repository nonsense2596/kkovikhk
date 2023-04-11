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
    private $mailaddress;
    private $unsubuuid;

    private $unsuburl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailsubject, $mailbody, $displayName, $mailaddress, $unsubuuid)
    {
        //
        $this->mailsubject = $mailsubject;
        $this->mailbody = $mailbody;
        $this->displayName = $displayName;
        $this->mailaddress = $mailaddress;
        $this->unsubuuid = $unsubuuid;

        $this->unsuburl = url('/unsubscribe/' . urlencode($this->mailaddress) . '/' . $unsubuuid);
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
                'unsuburl' => $this->unsuburl,
            ]);
    }
}

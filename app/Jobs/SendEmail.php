<?php

namespace App\Jobs;

use App\Mail\CallToVote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mailsubject;
    private $mailbody;
    private $displayName;
    private $mailaddress;
    private $unsubuuid;

    public $timeout = 20;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailsubject, $mailbody, $displayName, $mailaddress, $unsubuuid)
    {
        $this->mailsubject = $mailsubject;
        $this->mailbody = $mailbody;
        $this->displayName = $displayName;
        $this->mailaddress = $mailaddress;
        $this->unsubuuid = $unsubuuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new CallToVote($this->mailsubject, $this->mailbody, $this->displayName, $this->mailaddress, $this->unsubuuid);
        Mail::to($this->mailaddress)->send($email);
    }
}

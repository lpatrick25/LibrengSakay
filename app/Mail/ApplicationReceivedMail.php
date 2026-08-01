<?php

namespace App\Mail;

use App\Models\Applicant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Applicant $applicant
    ) {}

    public function build()
    {
        return $this
            ->subject('Application Received - ' . config('app.name'))
            ->view('emails.application-received');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $status;
    public $remarks;

    /**
     * Create a new message instance.
     */
    public function __construct($application, $status, $remarks)
    {
        $this->application = $application;
        $this->status = $status;
        $this->remarks = $remarks;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = "FYP Application " . ucfirst(strtolower($this->status));

        return $this->subject($subject)
                    ->view('emails.application-status')
                    ->with([
                        'application' => $this->application,
                        'status' => $this->status,
                        'remarks' => $this->remarks
                    ]);
    }
}

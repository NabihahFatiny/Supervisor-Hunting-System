<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TimeframeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $role;
    public $startDate;
    public $endDate;

    public function __construct($name, $role, $startDate, $endDate)
    {
        $this->name = $name;
        $this->role = $role;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this->view('emails.timeframe-notification')
                    ->subject('New Supervisor Hunting Timeframe Announced');
    }
}

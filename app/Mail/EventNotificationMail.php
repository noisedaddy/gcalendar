<?php

namespace App\Mail;

use App\Calendar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    protected $name;
    protected $datetime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data->name;
        $this->datetime = $data->datetimepicker;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Event submitted';
        return $this->view('email.email_notification')->with([
            'date' => $this->datetime,
            'event' => $this->name
        ]);;
    }
}

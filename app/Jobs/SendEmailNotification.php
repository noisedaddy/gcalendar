<?php

namespace App\Jobs;

use App\Calendar;
use App\Mail\EventNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $calendar;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->calendar = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EventNotificationMail($this->calendar);
        Mail::to($this->calendar->email)->send($email);
    }
}

<?php

namespace App\Jobs;

use App\Mail\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $day)
    {
        $this->details = $details;
        $this->day = $day;
    }
   

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Reminder($this->details, $this->day);
        // Mail::to("fajaramaulana.dev@gmail.com")->send($email);
    }
}

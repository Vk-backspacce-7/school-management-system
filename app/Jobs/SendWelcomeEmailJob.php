<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

   public function handle()
{
    try {

        \Log::info("Email job started for: ".$this->user->email);

        Mail::to($this->user->email)->send(new WelcomeMail($this->user));

        \Log::info("Email sent successfully to: ".$this->user->email);


 
    } catch (\Exception $e) {

        \Log::error("SendWelcomeEmailJob Failed: ".$e->getMessage());
    }
}
}
<?php

namespace App\Listeners;

use App\Mail\VerificationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendVerificationMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        if ($user->is_verified == 0) {
            $email = new VerificationEmail($user);
            if (isset($user->email)) {
                if (!empty($user->email)) {
                    Mail::to($user->email)->queue($email);
                }
            }
        }
    }
}

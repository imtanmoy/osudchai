<?php

namespace App\Listeners;

use App\Events\WelcomeVerifiedUser;
use App\Mail\SendWelcomeEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendWelcomeMail
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
     * @param  WelcomeVerifiedUser $event
     * @return void
     */
    public function handle(WelcomeVerifiedUser $event)
    {
        $user = $event->user;
        if ($user->is_verified == 1) {
            $email = new SendWelcomeEmail($user);
            if (isset($user->email)) {
                if (!empty($user->email)) {
                    Mail::to($user->email)->queue($email);
                }
            }
        }
    }
}

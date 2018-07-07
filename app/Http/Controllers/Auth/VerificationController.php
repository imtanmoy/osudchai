<?php

namespace App\Http\Controllers\Auth;

use App\Events\WelcomeVerifiedUser;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function verifyUser($token)
    {
        $verifyUser = UserVerification::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_verified) {
                $verifyUser->user->is_verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
                event(new WelcomeVerifiedUser($user));
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('status', $status);
    }
}

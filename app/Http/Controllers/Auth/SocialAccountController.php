<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService\Facades\SocialAccountService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $authUser = SocialAccountService::findOrCreate($provider_user, $provider);

        auth()->login($authUser, true);

        return redirect()->to('/home');

    }
}

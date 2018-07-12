<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/8/18
 * Time: 10:05 AM
 */

namespace App\Services\UserService;

use App\Models\SocialAccount;
use App\User;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Contracts\User as ProviderUser;


class SocialAccountService
{
    /**
     * @param ProviderUser $providerUser
     * @param $provider
     * @return mixed
     */
    public function findOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::where('provider', $provider)
            ->where('social_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $user = User::where('email', $providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'avatar' => $providerUser->getAvatar(),
                    'is_verified' => 1,
                ]);

                $user->customerGroup()->attach(1); // Default User Customer Group

                event(new Registered($user));
//                event(new WelcomeVerifiedUser($user));
            }

            $user->accounts()->create([
                'social_id' => $providerUser->getId(),
                'provider' => $provider,
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
            ]);
            return $user;
        }
    }
}
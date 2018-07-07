<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/7/2018
 * Time: 8:55 PM
 */

namespace App\Services\UserService;

use App\Services\UserService\Exceptions\UserHasNoEmailException;
use App\User;
use Illuminate\Support\Str;


class UserVerification
{
    /**
     * @param User $user
     * @return mixed
     * @throws UserHasNoEmailException
     */
    public function generate(User $user)
    {
        if (empty($user->email)) {
            throw new UserHasNoEmailException();
        }
        return $this->saveToken($user, $this->generateToken($user->email));
    }

    protected function generateToken($hint)
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
//        return bin2hex(openssl_random_pseudo_bytes($hint));
    }

    protected function saveToken(User $user, $token)
    {
        return $user->verification()->create([
            'token' => $token
        ]);
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/8/18
 * Time: 10:05 AM
 */

namespace App\Services\UserService\Facades;


use Illuminate\Support\Facades\Facade;

class SocialAccountService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'user.socialAccount';
    }
}
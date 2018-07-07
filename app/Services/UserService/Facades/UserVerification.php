<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/7/2018
 * Time: 9:22 PM
 */

namespace App\Services\UserService\Facades;


use Illuminate\Support\Facades\Facade;

class UserVerification extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'user.verification';
    }
}

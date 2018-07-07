<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/7/2018
 * Time: 10:29 PM
 */

namespace App\Services\UserService\Exceptions;


class UserHasNoEmailException extends \Exception
{
    protected $message = 'The given user instance has an empty or null email field.';
}

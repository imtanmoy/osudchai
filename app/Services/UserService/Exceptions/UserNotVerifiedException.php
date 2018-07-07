<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/7/2018
 * Time: 11:49 PM
 */

namespace App\Services\UserService\Exceptions;


class UserNotVerifiedException extends \Exception
{
    protected $message = 'This user is not verified';
}

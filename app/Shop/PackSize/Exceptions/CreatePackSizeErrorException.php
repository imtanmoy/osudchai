<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/14/2018
 * Time: 11:19 AM
 */

namespace App\Shop\PackSize\Exceptions;


class CreatePackSizeErrorException extends \Exception
{
    protected $message = 'PackSize can not be created';
}

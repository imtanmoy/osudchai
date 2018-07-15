<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:22 AM
 */

namespace App\Shop\Options\Exceptions;


class UpdateOptionErrorException extends \Exception
{
    protected $message = 'Option could not updated';

    protected $code = 500;
}
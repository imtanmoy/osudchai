<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:20 AM
 */

namespace App\Shop\Options\Exceptions;


class CreateOptionErrorException extends \Exception
{
    protected $message = 'Option could not created';

    protected $code = 500;

}
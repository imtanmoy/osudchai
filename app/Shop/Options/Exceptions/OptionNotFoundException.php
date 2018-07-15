<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:21 AM
 */

namespace App\Shop\Options\Exceptions;


class OptionNotFoundException extends \Exception
{
    protected $message = 'Option not found';

    protected $code = 404;
}
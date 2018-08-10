<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 8/10/2018
 * Time: 1:57 PM
 */

namespace App\Shop\Prescriptions\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PrescriptionNotFoundException extends NotFoundHttpException
{
    protected $message = 'Prescription Not Found';
}
<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/9/18
 * Time: 12:12 PM
 */

namespace App\Shop\Prescriptions\Transformations;


use App\Models\Prescription;
use Storage;

trait PrescriptionTransformable
{
    protected function transformPrescription(Prescription $prescription)
    {
        $prod = new Prescription;
        $prod->id = (int)$prescription->id;
        $prod->title = (string)$prescription->title;
        $prod->src = Storage::disk('public')->url($prescription->src);
        return $prod;
    }
}
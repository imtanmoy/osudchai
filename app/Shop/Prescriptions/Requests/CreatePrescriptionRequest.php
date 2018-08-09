<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/9/18
 * Time: 11:32 AM
 */

namespace App\Shop\Prescriptions\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreatePrescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'image' => 'required|file|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Prescription Title is required',
            'title.string' => 'Prescription Title is not valid',
            'image.required' => 'Prescription image is required',
            'image.file' => 'Prescription image is not valid',
            'image.max' => 'Prescription image size must be less than 5mb',
        ];
    }
}
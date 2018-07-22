<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/22/18
 * Time: 10:21 AM
 */

namespace App\Shop\Addresses\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{

    /**
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
//            'address1' => 'required|string',
//            'address2' => 'string',
//            'city_id' => 'required|numeric',
//            'area_id' => 'required|numeric',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
//    public function messages()
//    {
//        return [
//            'address1.required' => 'Address Line 1 is required',
//            'city_id.required' => 'City is required',
//            'area_id.required' => 'Area is required',
//        ];
//    }

}
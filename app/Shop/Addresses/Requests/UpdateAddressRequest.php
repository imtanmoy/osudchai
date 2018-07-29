<?php

namespace App\Shop\Addresses\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'address1' => 'required|string',
            'post_code' => 'numeric',
            'area_id' => 'required|integer',
            'city_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'address1.required' => 'Address Line 1 is required',
            'area_id.required' => 'City is required',
            'city_id.required' => 'Area is required',
        ];
    }
}

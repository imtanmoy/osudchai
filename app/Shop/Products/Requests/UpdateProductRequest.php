<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 8/6/18
 * Time: 12:24 PM
 */

namespace App\Shop\Products\Requests;


use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Gate::allows('users_manage')) {
            return false;
        }
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
            'name' => 'required|string',
            'sku' => 'required|string',
            'description' => 'string',
        ];
    }
}
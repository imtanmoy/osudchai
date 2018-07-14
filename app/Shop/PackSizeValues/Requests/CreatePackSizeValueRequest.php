<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/14/2018
 * Time: 12:26 PM
 */

namespace App\Shop\PackSizeValues\Requests;


use App\Shop\Base\BaseFormRequest;

class CreatePackSizeValueRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => ['required']
        ];
    }
}

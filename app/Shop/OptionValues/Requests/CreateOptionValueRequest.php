<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:38 AM
 */

namespace App\Shop\OptionValues\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateOptionValueRequest extends BaseFormRequest
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
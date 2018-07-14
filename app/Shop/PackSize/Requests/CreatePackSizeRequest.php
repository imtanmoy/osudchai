<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/14/2018
 * Time: 11:56 AM
 */

namespace App\Shop\PackSize\Requests;


use App\Shop\Base\BaseFormRequest;

class CreatePackSizeRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }
}

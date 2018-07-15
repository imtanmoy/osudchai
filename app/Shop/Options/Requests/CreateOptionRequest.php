<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/15/18
 * Time: 10:36 AM
 */

namespace App\Shop\Options\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateOptionRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }
}
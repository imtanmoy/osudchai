<?php
/**
 * Created by PhpStorm.
 * User: Tanmoy
 * Date: 7/20/2018
 * Time: 10:38 PM
 */

namespace App\Shop\OrderStatuses\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateOrderStatusRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:order_statuses']
        ];
    }
}

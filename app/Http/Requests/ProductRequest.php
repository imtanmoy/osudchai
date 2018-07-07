<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => 'required',
                        'sku' => 'required',
                        'description' => 'string',
                        'manufacturer_id' => 'required|integer',
                        'category_id' => 'required|integer',
                        'strength' => 'string',
                        'genericName' => 'string',
                        'available_qty' => 'required|numeric',
                        'minimum_order_qty' => 'required|numeric',
                        'stock_status' => 'required',
//                        'subtract_stock' => 'required',
                        'price' => 'required|numeric',
                    ];
                }
            case 'PUT':
                {
                    return [
                        'name' => 'required',
                        'sku' => 'required',
                        'description' => 'string',
                        'manufacturer_id' => 'required|integer',
                        'category_id' => 'required|integer',
                        'strength' => 'string',
                        'genericName' => 'string',
                        'available_qty' => 'required|numeric',
                        'minimum_order_qty' => 'required|numeric',
                        'stock_status' => 'required',
//                        'subtract_stock' => 'required',
                        'price' => 'required|numeric',
                    ];
                }
            case 'PATCH':
                {
                    return [
                        'name' => 'required',
                        'sku' => 'required',
                        'description' => 'string',
                        'manufacturer_id' => 'required|integer',
                        'category_id' => 'required|integer',
                        'strength' => 'string',
                        'genericName' => 'string',
                        'available_qty' => 'required|numeric',
                        'minimum_order_qty' => 'required|numeric',
                        'stock_status' => 'required',
//                        'subtract_stock' => 'required',
                        'price' => 'required|numeric',
                    ];
                }
            default:
                return [];
                break;
        }
    }
}

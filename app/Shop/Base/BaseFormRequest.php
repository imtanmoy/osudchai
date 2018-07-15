<?php

namespace App\Shop\Base;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
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
}

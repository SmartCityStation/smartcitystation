<?php

namespace App\Http\Requests\API\Backend;

use App\Models\Backend\Type_variable;
use InfyOm\Generator\Request\APIRequest;

class CreateType_variableAPIRequest extends APIRequest
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
        return Type_variable::$rules;
    }
}

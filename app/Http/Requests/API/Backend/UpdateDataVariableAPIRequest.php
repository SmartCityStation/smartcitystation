<?php

namespace App\Http\Requests\API\Backend;

use App\Models\Backend\DataVariable;
use InfyOm\Generator\Request\APIRequest;

class UpdateDataVariableAPIRequest extends APIRequest
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
        $rules = DataVariable::$rules;
        
        return $rules;
    }
}

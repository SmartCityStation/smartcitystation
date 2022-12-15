<?php

namespace App\Http\Requests\API\Frontend;

use App\Models\Frontend\Measure;
use InfyOm\Generator\Request\APIRequest;

class CreateMeasureAPIRequest extends APIRequest
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
        return Measure::$rules;
    }
}

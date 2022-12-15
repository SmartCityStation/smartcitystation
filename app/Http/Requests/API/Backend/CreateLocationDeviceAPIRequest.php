<?php

namespace App\Http\Requests\API\Backend;

use App\Models\Backend\LocationDevice;
use InfyOm\Generator\Request\APIRequest;

class CreateLocationDeviceAPIRequest extends APIRequest
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
        return LocationDevice::$rules;
    }
}

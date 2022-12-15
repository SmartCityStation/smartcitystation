<?php

namespace App\Repositories\Backend;

use App\Models\Backend\VariableDevice;
use App\Repositories\BaseRepository;

/**
 * Class VariableDeviceRepository
 * @package App\Repositories\Backend
 * @version May 8, 2021, 2:28 pm UTC
*/

class VariableDeviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'device_id',
        'data_variable_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return VariableDevice::class;
    }
}

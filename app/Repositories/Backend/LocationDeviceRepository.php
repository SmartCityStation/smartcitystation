<?php

namespace App\Repositories\Backend;

use App\Models\Backend\LocationDevice;
use App\Repositories\BaseRepository;

/**
 * Class LocationDeviceRepository
 * @package App\Repositories\Backend
 * @version May 5, 2021, 10:37 pm UTC
*/

class LocationDeviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'address',
        'installation_date',
        'installation_hour',
        'remove_date',
        'remove_hour',
        'latitude',
        'length',
        'device_id',
        'area_id',
        'project_id'
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
        return LocationDevice::class;
    }
}

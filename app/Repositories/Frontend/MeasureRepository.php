<?php

namespace App\Repositories\Frontend;

use App\Models\Frontend\Measure;
use App\Repositories\BaseRepository;

/**
 * Class MeasureRepository
 * @package App\Repositories\Frontend
 * @version May 13, 2021, 5:16 pm UTC
*/

class MeasureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'time',
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
        return Measure::class;
    }
}

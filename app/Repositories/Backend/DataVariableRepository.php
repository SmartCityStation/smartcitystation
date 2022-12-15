<?php

namespace App\Repositories\Backend;

use App\Models\Backend\DataVariable;
use App\Repositories\BaseRepository;

/**
 * Class DataVariableRepository
 * @package App\Repositories\Backend
 * @version April 30, 2021, 10:06 pm UTC
*/

class DataVariableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type_variable_id'
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
        return DataVariable::class;
    }
}

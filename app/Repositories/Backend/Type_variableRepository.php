<?php

namespace App\Repositories\Backend;

use App\Models\Backend\Type_variable;
use App\Repositories\BaseRepository;

/**
 * Class Type_variableRepository
 * @package App\Repositories\Backend
 * @version April 30, 2021, 5:13 pm UTC
*/

class Type_variableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return Type_variable::class;
    }
}

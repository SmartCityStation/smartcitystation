<?php

namespace App\Repositories\Backend;

use App\Models\Backend\Village;
use App\Repositories\BaseRepository;

/**
 * Class VillageRepository
 * @package App\Repositories\Backend
 * @version May 3, 2021, 9:30 pm UTC
*/

class VillageRepository extends BaseRepository
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
        return Village::class;
    }
}

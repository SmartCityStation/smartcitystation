<?php

namespace App\Repositories\Backend;

use App\Models\Backend\Project;
use App\Repositories\BaseRepository;

/**
 * Class AreaRepository
 * @package App\Repositories\Backend
 * @version May 3, 2021, 10:22 pm UTC
*/

class ProjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'company',
        'start_date',
        'end_date',
        'user_id'
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
        return Project::class;
    }
}

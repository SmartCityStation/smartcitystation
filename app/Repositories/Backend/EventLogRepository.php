<?php

namespace App\Repositories\Backend;

use App\Models\Backend\EventLog;
use App\Repositories\BaseRepository;

/**
 * Class EventLogRepository
 * @package App\Repositories\Backend
 * @version August 19, 2021, 5:20 pm UTC
*/

class EventLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date_event',
        'type_event'
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
        return EventLog::class;
    }
}

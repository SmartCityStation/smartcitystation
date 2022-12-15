<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateEventLogAPIRequest;
use App\Http\Requests\API\Backend\UpdateEventLogAPIRequest;
use App\Models\Backend\EventLog;
use App\Repositories\Backend\EventLogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class EventLogController
 * @package App\Http\Controllers\API\Backend
 */

class EventLogAPIController extends AppBaseController
{
    /** @var  EventLogRepository */
    private $eventLogRepository;

    public function __construct(EventLogRepository $eventLogRepo)
    {
        $this->eventLogRepository = $eventLogRepo;
    }

    /**
     * Display a listing of the EventLog.
     * GET|HEAD /eventLogs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $eventLogs = $this->eventLogRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($eventLogs->toArray(), 'Event Logs retrieved successfully');
    }

    /**
     * Store a newly created EventLog in storage.
     * POST /eventLogs
     *
     * @param CreateEventLogAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateEventLogAPIRequest $request)
    {
        $input = $request->all();

        $eventLog = $this->eventLogRepository->create($input);

        return $this->sendResponse($eventLog->toArray(), 'Event Log saved successfully');
    }

    /**
     * Display the specified EventLog.
     * GET|HEAD /eventLogs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var EventLog $eventLog */
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            return $this->sendError('Event Log not found');
        }

        return $this->sendResponse($eventLog->toArray(), 'Event Log retrieved successfully');
    }

    /**
     * Update the specified EventLog in storage.
     * PUT/PATCH /eventLogs/{id}
     *
     * @param int $id
     * @param UpdateEventLogAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEventLogAPIRequest $request)
    {
        $input = $request->all();

        /** @var EventLog $eventLog */
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            return $this->sendError('Event Log not found');
        }

        $eventLog = $this->eventLogRepository->update($input, $id);

        return $this->sendResponse($eventLog->toArray(), 'EventLog updated successfully');
    }

    /**
     * Remove the specified EventLog from storage.
     * DELETE /eventLogs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var EventLog $eventLog */
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            return $this->sendError('Event Log not found');
        }

        $eventLog->delete();

        return $this->sendSuccess('Event Log deleted successfully');
    }
}

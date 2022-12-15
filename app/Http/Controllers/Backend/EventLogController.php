<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateEventLogRequest;
use App\Http\Requests\Backend\UpdateEventLogRequest;
use App\Repositories\Backend\EventLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class EventLogController extends AppBaseController
{
    /** @var  EventLogRepository */
    private $eventLogRepository;

    public function __construct(EventLogRepository $eventLogRepo)
    {
        $this->eventLogRepository = $eventLogRepo;
    }

    /**
     * Display a listing of the EventLog.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $eventLogs = $this->eventLogRepository->paginate(5);

        return view('backend.event_logs.index')
            ->with('eventLogs', $eventLogs);
    }

    /**
     * Show the form for creating a new EventLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.event_logs.create');
    }

    /**
     * Store a newly created EventLog in storage.
     *
     * @param CreateEventLogRequest $request
     *
     * @return Response
     */
    public function store(CreateEventLogRequest $request)
    {
        $input = $request->all();

        $eventLog = $this->eventLogRepository->create($input);

        Flash::success('Registro de eventos Guardado con Exito.');

        return redirect(route('admin.eventLogs.index'));
    }

    /**
     * Display the specified EventLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            Flash::error('Event Log not found');

            return redirect(route('admin.eventLogs.index'));
        }

        return view('backend.event_logs.show')->with('eventLog', $eventLog);
    }

    /**
     * Show the form for editing the specified EventLog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            Flash::error('Event Log not found');

            return redirect(route('admin.eventLogs.index'));
        }

        return view('backend.event_logs.edit')->with('eventLog', $eventLog);
    }

    /**
     * Update the specified EventLog in storage.
     *
     * @param int $id
     * @param UpdateEventLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEventLogRequest $request)
    {
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            Flash::error('Event Log not found');

            return redirect(route('admin.eventLogs.index'));
        }

        $eventLog = $this->eventLogRepository->update($request->all(), $id);

        Flash::success('Registro de eventos Actualizado con Exito.');

        return redirect(route('admin.eventLogs.index'));
    }

    /**
     * Remove the specified EventLog from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $eventLog = $this->eventLogRepository->find($id);

        if (empty($eventLog)) {
            Flash::error('Event Log not found');

            return redirect(route('admin.eventLogs.index'));
        }

        $this->eventLogRepository->delete($id);

        Flash::success('Registro de eventos Eliminado con Exito.');

        return redirect(route('admin.eventLogs.index'));
    }
}

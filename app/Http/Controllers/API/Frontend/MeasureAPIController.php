<?php

namespace App\Http\Controllers\API\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Requests\API\Frontend\CreateMeasureAPIRequest;
use App\Http\Requests\API\Frontend\UpdateMeasureAPIRequest;
use App\Models\Frontend\Measure;
use App\Repositories\Frontend\MeasureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Mail\sendEmail as MailSendEmail;
use App\Mail\sendEmail2;
use App\Mail\sendEmailNew;
use Response;
use App\Models\Backend\Device;
use App\Models\Backend\DataVariable;
use App\Notifications\sendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\Backend\EventLog;
use App\Models\Backend\LocationDevice;
use App\Models\Backend\Project;

/**
 * Class MeasureController
 * @package App\Http\Controllers\API\Frontend
 */

class MeasureAPIController extends AppBaseController
{
    /** @var  MeasureRepository */
    private $measureRepository;

    private $codeDevice;
    private $codeVariable;
    private $measuresAlerts = array();
    
    public function __construct(MeasureRepository $measureRepo)
    {
        $this->measureRepository = $measureRepo;
    }

    /**
     * Display a listing of the Measure.
     * GET|HEAD /measures
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $measures = $this->measureRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($measures->toArray(), 'Measures retrieved successfully');
    }

    /**
     * Store a newly created Measure in storage.
     * POST /measures
     *
     * @param CreateMeasureAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMeasureAPIRequest $request)
    {
        $input = $request->all();

        $measure = $this->measureRepository->create($input);

        return $this->sendResponse($measure->toArray(), 'Measure saved successfully');
    }

    /**
     * Display the specified Measure.
     * GET|HEAD /measures/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Measure $measure */
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            return $this->sendError('Measure not found');
        }

        return $this->sendResponse($measure->toArray(), 'Measure retrieved successfully');
    }

    /**
     * Update the specified Measure in storage.
     * PUT/PATCH /measures/{id}
     *
     * @param int $id
     * @param UpdateMeasureAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMeasureAPIRequest $request)
    {
        $input = $request->all();

        /** @var Measure $measure */
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            return $this->sendError('Measure not found');
        }

        $measure = $this->measureRepository->update($input, $id);

        return $this->sendResponse($measure->toArray(), 'Measure updated successfully');
    }

    /**
     * Remove the specified Measure from storage.
     * DELETE /measures/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Measure $measure */
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            return $this->sendError('Measure not found');
        }

        $measure->delete();

        return $this->sendSuccess('Measure deleted successfully');
    }

    /**
     * This function save a json of the measures for minutes.
     */
    public function measureRecord(Request $request)
    {

        if ($request->isMethod('post')) {
            $result = $this->validateJson($request);
            if ($result == "Ok") {
                if ($this->insertMeasure($request) == 200) {

                    // $this->lookinForAlert($request);
                    //  if the measuresAlerts array has data, a threshold notification must be sent to the administrator.
                    // if (sizeof($this->measuresAlerts) > 1) {
                        // function send email
                    //     $this->userEmail();
                    // }
                    return $this->sendResponse(200, 'Ok');
                } else {
                    $this->insertEventLog('501 Error: Al ingresar los datos sobre la Base de Datos');
                    return $this->sendResponse(501, 'Error: Al ingresar los datos sobre la Base de Datos');
                }
            } else {
                $reply = substr($result, 0, 3);
                switch ($reply) {
                    case '502':
                        return $this->sendResponse(502, $result);
                        break;
                    case '503':
                        return $this->sendResponse(503, $result);
                        break;
                    case '504':
                        return $this->sendResponse(504, $result);
                        break;
                    case '505':
                        return $this->sendResponse(505, $result);
                        break;
                    case '506':
                        return $this->sendResponse(506, $result);
                        break;
                    case '507':
                        return $this->sendResponse(507, $result);
                        break;
                    case '508':
                        return $this->sendResponse(508, $result);
                        break;
                }
            }
        }
       
    }

    private function validateJson($Measures)
    {
        $result = "";

        $measuringData = $Measures->input();


        foreach ($measuringData as $value) {

            if (empty($value['device'])) {
                $result = '508 Error: No hay dato en device';
                $this->insertEventLog($result);
                break;
            } else {
                if (empty($value['variable'])) {
                    $result = '506 Error: No hay dato en variable. ';
                    $this->insertEventLog($result);
                    break;
                } else {
                    $this->codeDevice = $this->getIdDevice($value['device']);
                    if (isset($this->codeDevice) && ($this->codeDevice > 0)) {
                        $this->codeVariable = $this->getIdVariable($value['variable']);
                        if (isset($this->codeVariable) && ($this->codeVariable > 0)) {
                            foreach ($value['data'] as $value2) {
                                if (empty($value2['time'])) {
                                    $result = '507 Error: No hay dato en time. ';
                                    $this->insertEventLog($result);
                                    break;
                                } else {
                                    if ((float)$value2['value'] == 0) {
                                        $result = '504 Error: No hay dato en value. ';
                                        $this->insertEventLog($result);
                                        break;
                                    } else {
                                        $result = "Ok";
                                        // $this->lookinForAlert($value['device'], $value2['time'], $value['variable'], $value2['value']);
                                    }
                                }
                            }
                        } else {
                            $result = '502 Error: La variable ' . $value['variable'] . ' No es valida.';
                            $this->insertEventLog($result);
                            break;
                        }
                    } else {
                        $result = '503 Error: El codigo dispositivo ' . $value['device'] . ' No es valido.';
                        $this->insertEventLog($result);
                        break;
                    }
                }
            }
        }
        return $result;
    }


    /**
     * This function get the id that match with the input parameter.
     */
    private function getIdDevice($codDevice)
    {
        $devId = 0;
        $deviceId = Device::select('id')
            ->where('device_code', $codDevice)
            ->where('state', 1)
            ->get();

        if (count($deviceId) > 0) {
            foreach ($deviceId as $codVar) {
                $devId = $codVar->id;
            }
        }
        return $devId;
    }

    /**
     * This function get the id that match with the input parameter.
     */
    private function getIdVariable($codVariable)
    {
        $varId = 0;
        $variableId = DataVariable::select('id')
            ->where('name', $codVariable)
            ->get();

        if (count($variableId) > 0) {
            foreach ($variableId as $vbleId) {
                $varId = $vbleId->id;
            }
        }
        return $varId;
    }


    //This function valid that data variable doesn`t exceed the treshold 
    // private function lookinForAlert($device, $time, $variable, $data): void
    private function lookinForAlert($Measures): void
    {
        $measuringData = $Measures->input();

        foreach ($measuringData as $value) {
            $alertVar = 0;
            $alertVariable = [];

            foreach ($value['data'] as $value2) {

                    if (Carbon::parse($value2['time'])->format('H:m:s') <= '18:00:00' && Carbon::parse($value2['time'])->format('H:m:s') >= '00:00:00') {

                        $alertVariable = LocationDevice::select('subsectors.alert_threshold_day')
                            ->join('subsectors', 'subsectors.id', '=', 'location_devices.subsector_id')
                            ->where('subsectors.alert_threshold_day', '<', $value2['value'])
                            ->where('location_devices.device_id', $this->codeDevice)
                            ->get();
    
                        if (count($alertVariable) > 0) {
                            foreach ($alertVariable as $alert) {
                                $alertVar = $alert->alert_threshold_day;
                                $diff = $value2['value'] - $alertVar; 
                                array_push($this->measuresAlerts , array($value['device'], $value2['time'], $value['variable'], $value2['value'], $alertVar, $diff));
                            }
                        }
                    } else {
    
                        $alertVariable = LocationDevice::select('subsectors.alert_threshold_night')
                            ->join('subsectors', 'subsectors.id', '=', 'location_devices.subsector_id')
                            ->where('subsectors.alert_threshold_night', '<', $value2['value'])
                            ->where('location_devices.device_id', $this->codeDevice)
                            ->get();
    
    
                        if (count($alertVariable) > 0) {
                            foreach ($alertVariable as $alert) {
                                $alertVar = $alert->alert_threshold_night;
                                $diff =  $value2['value'] - $alertVar;
                                array_push($this->measuresAlerts, array($value['device'], $value2['time'], $value['variable'], $value2['value'], $alertVar, $diff));
                            }
                        }
                    }
                
            }
        }
    }



    

    /**
     * this function send email towards the mailabler sendEmailNew.php, send global variable 
     */

    private function userEmail()
    {
        // $userEmail = User::select('email')
        //     ->where('type', 'admin')
        //     ->first();

        $userEmail = LocationDevice::select('users.email')
            ->join('projects', 'projects.id', '=', 'location_devices.project_id')
            ->join('users', 'users.id', '=', 'projects.user_id')
            ->where('device_id', $this->codeDevice)
            ->first();

        Mail::to($userEmail)->send(new sendEmailNew($this->measuresAlerts));
    }

    private function insertMeasure($inRequest)
    {

        try {
            $measuringData = $inRequest->input();
            foreach ($measuringData as $value) {
                foreach ($value['data'] as $key => $value2) {
                    // dd(' Dispositivo:' . $this->codeDevice . ' Variable:' . $this->codeVariable . ' - ' . $value2);
                    $objMeasure = new Measure();
                    $objMeasure->time = $value2['time'];
                    $objMeasure->data = (float)$value2['value'];
                    $objMeasure->device_id = (int)$this->codeDevice;
                    $objMeasure->data_variable_id = (int)$this->codeVariable;
                    $objMeasure->save();
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            return 501;
        }

        return 200;
    }


    /**
     * This function save the event logs
     */
    private function insertEventLog($description): void
    {
        try {
            $dateEvent = Carbon::now()->toDateTimeString();

            EventLog::insert([
                'date_event' => $dateEvent,
                'type_event' => "Register Measure",
                'description' => $description,
                'created_at' => $dateEvent,
                'updated_at' => $dateEvent
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

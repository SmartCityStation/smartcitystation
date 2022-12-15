<?php

namespace App\Http\Controllers\API\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Frontend\CreateMeasureAPIRequest;
use App\Http\Requests\API\Frontend\UpdateMeasureAPIRequest;
use App\Mail\sendEmailNew;
use App\Models\Backend\DataVariable;
use App\Models\Backend\Device;
use App\Models\Frontend\Measure;
use Illuminate\Http\Request;
use Mail;
use Response;
use App\Models\Backend\EventLog;
use Carbon\Carbon;

class AmbientalAPIController extends Controller
{
    //variables globales
    private $codeDevice;
    private $codeTemp;
    private $codeHum;
    private $codePres;

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

        // return $this->sendResponse($measures->toArray(), 'Measures retrieved successfully');
        return [$measures->toArray(), 'Measures retrieved successfully'];
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

        // return $this->sendResponse($measure->toArray(), 'Measure saved successfully');
        return [$measure->toArray(), 'Measure saved successfully'];
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

        // return $this->sendResponse($measure->toArray(), 'Measure retrieved successfully');
        return [$measure->toArray(), 'Measures retrieved successfully'];
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

        // return $this->sendResponse($measure->toArray(), 'Measure updated successfully');
        return [$measure->toArray(), 'Measure updated successfully'];
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


    public function ambientalRecord(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->validateJson($request);
            if ($result == "Ok") {
                if ($this->insertMeasure($request) == 200) {
                    
                    return ["ok"=>"200"];  
                } else {
                    $this->insertEventLog('501 Error: Al ingresar los datos sobre la Base de Datos');
                    return ["501"=>"Error: Al ingresar los datos sobre la Base de Datos"];
                }
            } else {
                $reply = substr($result, 0, 3);
                switch ($reply) {
                    case '502':
                        //return $this->sendResponse(502, $result);  
                        return ["502"=>$result];    
                        break;
                    case '503':
                        //return $this->sendResponse(503, $result); 
                        return ["503"=>$result];   
                        break; 
                    case '504':
                        //return $this->sendResponse(504, $result); 
                        return ["504"=>$result];   
                        break;     
                    case '505':
                        //return $this->sendResponse(505, $result); 
                        return ["505"=>$result];   
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
                $this->codeDevice = $this->getIdDevice($value['device']);
                if (isset($this->codeDevice) && ($this->codeDevice > 0)) {
                    foreach ($value['data'] as $value2) {
                        if (empty($value2['time'])) {
                            $result = '507 Error: No hay dato en time. ';
                            $this->insertEventLog($result);
                            break;
                        } else {

                            if ((float)$value2['temp'] == 0) {
                                $result = '504 Error: No hay dato en temp. ';
                                $this->insertEventLog($result);
                                break;
                            } else {
                                if ((float)$value2['hum'] == 0) {
                                    $result = '505 Error: No hay dato en hum. ';
                                    $this->insertEventLog($result);
                                } else {
                                    if ((float)$value2['presion'] == 0) {
                                        $result = '506 Error: No hay dato en presion. ';
                                        $this->insertEventLog($result);
                                    } else {
                                        $temp = 'Temperatura';
                                        $this->codeTemp = $this->getIdTemperature($temp);
                                        if (isset($this->codeTemp) && ($this->codeTemp > 0)) {
                                            $hum = 'Humedad relativa';
                                            $this->codeHum = $this->getIdHumidity($hum);
                                            if (isset($this->codeHum) && ($this->codeHum > 0)) {
                                                $pres = 'Presión atmosférica';
                                                $this->codePres = $this->getIdPresion($pres);
                                                if (isset($this->codePres) && ($this->codePres > 0)) {
                                                    $result = "Ok";
                                                } else {
                                                    $result = '502 Error: La variable ' . $pres . ' No es valida.';
                                                    $this->insertEventLog($result);
                                                    break;
                                                }
                                            } else {
                                                $result = '502 Error: La variable ' . $hum . ' No es valida.';
                                                $this->insertEventLog($result);
                                                break;
                                            }
                                        } else {
                                            $result = '503 Error: La variable ' . $temp . ' No es valida.';
                                            $this->insertEventLog($result);
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $result = '503 Error: El codigo dispositivo ' . $value['device'] . ' No es valido.';
                    $this->insertEventLog($result);
                    break;
                }
            }
        }
        return $result;
    }

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

    private function getIdHumidity($codHum)
    {
        $humidityId = 0;
        $humId = DataVariable::select('id')
            ->where('name', $codHum)
            ->get();

        if (count($humId) > 0) {
            foreach ($humId as $codVar) {
                $humidityId = $codVar->id;
            }
        }
        return $humidityId;
    }

    private function getIdTemperature($codTemp)
    {
        $temperatureId = 0;
        $tempId = DataVariable::select('id')
            ->where('name', $codTemp)
            ->get();

        if (count($tempId) > 0) {
            foreach ($tempId as $codVar) {
                $temperatureId = $codVar->id;
            }
        }
        return $temperatureId;
    }

    private function getIdPresion($codPres)
    {
        $presionId = 0;
        $presId = DataVariable::select('id')
            ->where('name', $codPres)
            ->get();

        if (count($presId) > 0) {
            foreach ($presId as $codVar) {
                $presionId = $codVar->id;
            }
        }
        return $presionId;
    }


    private function insertMeasure($inRequest)
    {

        try {
            if (isset($this->codeTemp)) {
                $measuringData = $inRequest->input();
                foreach ($measuringData as $value) {
                    foreach ($value['data'] as $key => $value2) {
                        // dd(' Dispositivo:' . $this->codeDevice . ' Variable:' . $this->codeVariable . ' - ' . $value2);
                        $objMeasure = new Measure();
                        $objMeasure->time = $value2['time'];
                        $objMeasure->data = (float)$value2['temp'];
                        $objMeasure->device_id = (int)$this->codeDevice;
                        $objMeasure->data_variable_id = (int)$this->codeTemp;
                        $objMeasure->save();
                    }
                }
            }

            if (isset($this->codeHum)) {
                $measuringData = $inRequest->input();
                foreach ($measuringData as $value) {
                    foreach ($value['data'] as $key => $value2) {
                        // dd(' Dispositivo:' . $this->codeDevice . ' Variable:' . $this->codeVariable . ' - ' . $value2);
                        $objMeasure = new Measure();
                        $objMeasure->time = $value2['time'];
                        $objMeasure->data = (float)$value2['hum'];
                        $objMeasure->device_id = (int)$this->codeDevice;
                        $objMeasure->data_variable_id = (int)$this->codeHum;
                        $objMeasure->save();
                    }
                }
            }

            if ($this->codePres) {
                $measuringData = $inRequest->input();
                    foreach ($measuringData as $value) {
                        foreach ($value['data'] as $key => $value2) {
                            // dd(' Dispositivo:' . $this->codeDevice . ' Variable:' . $this->codeVariable . ' - ' . $value2);
                            $objMeasure = new Measure();
                            $objMeasure->time = $value2['time'];
                            $objMeasure->data = (float)$value2['presion'];
                            $objMeasure->device_id = (int)$this->codeDevice;
                            $objMeasure->data_variable_id = (int)$this->codePres;
                            $objMeasure->save();
                        }
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

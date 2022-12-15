<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Frontend\CreateMeasureAPIRequest;
use App\Http\Requests\API\Frontend\UpdateMeasureAPIRequest;
use App\Models\Backend\DataVariable;
use App\Models\Backend\Device;
use App\Models\Frontend\Measure;
use Illuminate\Http\Request;

class MaterialParticulatedAPIController extends Controller
{
    //variables globales
    private $codeDevice;
    private $codePM25;
    private $codePM10;

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


    public function materialRecord(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->validateJson($request);
            if ($result == "Ok") {
                if ($this->insertMeasure($request) == 200) {

                    return ["ok" => "200"];
                } else {
                    $this->insertEventLog('501 Error: Al ingresar los datos sobre la Base de Datos');
                    return ["501" => "Error: Al ingresar los datos sobre la Base de Datos"];
                }
            } else {
                $reply = substr($result, 0, 3);
                switch ($reply) {
                    case '502':
                        //return $this->sendResponse(502, $result);  
                        return ["502" => $result];
                        break;
                    case '503':
                        //return $this->sendResponse(503, $result); 
                        return ["503" => $result];
                        break;
                    case '504':
                        //return $this->sendResponse(504, $result); 
                        return ["504" => $result];
                        break;
                    case '505':
                        //return $this->sendResponse(505, $result); 
                        return ["505" => $result];
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

                            if ((float)$value2['PM 10'] == 0) {
                                $result = '504 Error: No hay dato en PM 10. ';
                                $this->insertEventLog($result);
                                break;
                            } else {
                                if ((float)$value2['PM 2.5'] == 0) {
                                    $result = '505 Error: No hay dato en PM 2.5. ';
                                    $this->insertEventLog($result);
                                } else {
                                    $PM10 = 'PM 10';
                                    $this->codePM10 = $this->getIdPM10($PM10);
                                    if (isset($this->codePM10) && ($this->codePM10 > 0)) {
                                        $PM25 = 'PM 2.5';
                                        $this->codePM25 = $this->getIdPM25($PM25);
                                        if (isset($this->codePM25) && ($this->codePM25 > 0)) {
                                            $result = "Ok";
                                        } else {
                                            $result = '502 Error: La variable ' . $PM25 . ' No es valida.';
                                            $this->insertEventLog($result);
                                            break;
                                        }
                                    } else {
                                        $result = '503 Error: La variable ' . $PM10 . ' No es valida.';
                                        $this->insertEventLog($result);
                                        break;
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

    private function getIdPM10($codePM10)
    {
        $pm10 = 0;
        $pm10Id = DataVariable::select('id')
            ->where('name', $codePM10)
            ->get();

        if (count($pm10Id) > 0) {
            foreach ($pm10Id as $codVar) {
                $pm10 = $codVar->id;
            }
        }
        return $pm10;
    }

    private function getIdPM25($codePM25)
    {
        $pm25 = 0;
        $pm25Id = DataVariable::select('id')
            ->where('name', $codePM25)
            ->get();

        if (count($pm25Id) > 0) {
            foreach ($pm25Id as $codVar) {
                $pm25 = $codVar->id;
            }
        }
        return $pm25;
    }


    private function insertMeasure($inRequest)
    {

        try {
            if (isset($this->codePM10)) {
                $measuringData = $inRequest->input();
                foreach ($measuringData as $value) {
                    foreach ($value['data'] as $key => $value2) {
                        //  dd(' Dispositivo:' . $this->codeDevice . ' Variable:' . (int)$this->codePM10);
                        $objMeasure = new Measure();
                        $objMeasure->time = $value2['time'];
                        $objMeasure->data = (float)$value2['PM 10'];
                        $objMeasure->device_id = (int)$this->codeDevice;
                        $objMeasure->data_variable_id = (int)$this->codePM10;
                        $objMeasure->save();
                    }
                }
            }

            if (isset($this->codePM25)) {
                $measuringData = $inRequest->input();
                foreach ($measuringData as $value) {
                    foreach ($value['data'] as $key => $value2) {
                        // dd(' Dispositivo:' . $this->codeDevice . ' Variable:' . $this->codePM25 . ' - ' . $value2);
                        $objMeasure = new Measure();
                        $objMeasure->time = $value2['time'];
                        $objMeasure->data = (float)$value2['PM 2.5'];
                        $objMeasure->device_id = (int)$this->codeDevice;
                        $objMeasure->data_variable_id = (int)$this->codePM25;
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
}

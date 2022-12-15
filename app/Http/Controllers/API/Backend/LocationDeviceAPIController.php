<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateLocationDeviceAPIRequest;
use App\Http\Requests\API\Backend\UpdateLocationDeviceAPIRequest;
use App\Models\Backend\LocationDevice;
use App\Repositories\Backend\LocationDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Backend\Area;
use App\Models\Backend\Device;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Backend\EventLog;
use App\Models\Backend\Project;
use Illuminate\Support\Carbon;


/**
 * Class LocationDeviceController
 * @package App\Http\Controllers\API\Backend
 */

class LocationDeviceAPIController extends AppBaseController
{
    /** @var  LocationDeviceRepository */
    private $locationDeviceRepository;
    private $codeDevice;

    public function __construct(LocationDeviceRepository $locationDeviceRepo)
    {
        $this->locationDeviceRepository = $locationDeviceRepo;
    }

    /**
     * Display a listing of the LocationDevice.
     * GET|HEAD /locationDevices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $locationDevices = $this->locationDeviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($locationDevices->toArray(), 'Location Devices retrieved successfully');
    }

    /**
     * Store a newly created LocationDevice in storage.
     * POST /locationDevices
     *
     * @param CreateLocationDeviceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationDeviceAPIRequest $request)
    {
        $input = $request->all();

        $locationDevice = $this->locationDeviceRepository->create($input);

        return $this->sendResponse($locationDevice->toArray(), 'Location Device saved successfully');
    }


    /**
     * 
     * 
     * Display the specified LocationDevice.
     * GET|HEAD /locationDevices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LocationDevice $locationDevice */
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            return $this->sendError('Location Device not found');
        }

        return $this->sendResponse($locationDevice->toArray(), 'Location Device retrieved successfully');
    }



    public function locationRecord(Request $request)
    {
        // se valida que el parametro sea de tipo post
        if ($request->isMethod('post')) {
            // se llama a la función validateJson, para validar la integridad de los datos.
            $result = $this->validateJson($request);
            // si la validacion es correcta
            if ($result == "Ok") {
                // se llama a la función insetLocation, quien hara el registro sobre la B. de D.
                if ($this->insertLocation($request) == 200) {
                    return $this->sendResponse(200, 'Ok');
                } else {
                    // Si hay error al insertar el registro sobre la B. de D.
                    $this->insertEventLog("501 Error: Al ingresar los datos sobre la Base de Datos", 1);
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
                    case '509':
                        return $this->sendResponse(509, $result);
                        break;
                    case '510':
                        return $this->sendResponse(510, $result);
                        break;
                }
            }
        }
    }

    private function validateJson($location)
    {
        $result = "";
        // recorremos la variable locatingData en donde estan los datos del json que vamos a validar
        $locatingData = $location->input();
        // ciclo que recorrera el json
        foreach ($locatingData as $key => $value) {
            // validar si esta vacio el dato codigo_dispositivo
            if (empty($value['codigo_dispositivo'])) {
                $result = '510 Error: No hay dato en codigo_dispositivo';
                $this->insertEventLog($result, 1);
                break;
            } else {
                // validar si esta vacio el dato Direccion
                if (empty($value['Direccion'])) {
                    $result = '509 Error: No hay dato en Direccion. ';
                    $this->insertEventLog($result, 1);
                    break;
                } else {
                    // validar si esta vacio el dato Fecha_ins
                    if (empty($value['Fecha_ins'])) {
                        $result = '508 Error: No hay dato en Fecha_ins. ';
                        $this->insertEventLog($result, 1);
                        break;
                    } else {
                        // validar si esta vacio el dato Hora_ins
                        if (empty($value['Hora_ins'])) {
                            $result = '507 Error: No hay dato en Hora_ins. ';
                            $this->insertEventLog($result, 1);
                            break;
                        } else {
                            // validar si esta vacio el dato Latitud
                            if ((float)$value['Latitud'] == 0) {
                                $result = '506 Error: No hay dato en Latitud ';
                                $this->insertEventLog($result, 1);
                                break;
                            } else {
                                // validar si esta vacio el dato Longitud
                                if ((float)$value['Longitud'] == 0) {
                                    $result = '505 Error: No hay dato en Longitud ';
                                    $this->insertEventLog($result, 1);
                                    break;
                                } else {
                                    // validar si esta vacio el dato Area
                                    if (empty($value['Area'])) {
                                        $result = '504 Error: No hay dato en Area ';
                                        $this->insertEventLog($result, 1);
                                        break;
                                    } else {
                                        if (empty($value['nombre_proyecto'])) {
                                            $result = '511 Error: No hay dato en nombre proyecto ';
                                            $this->insertEventLog($result, 1);
                                            break;
                                        } else {
                                            // se llama a la función getDevice, quien retorna el id del dispositivo,
                                            // el cual es asignado a la variable global codeDevice.
                                            $this->codeDevice =  $this->getIdDevice($value['codigo_dispositivo']);
                                            // si la variable global  esta definida y no es null ni cero
                                            if (isset($this->codeDevice) && ($this->codeDevice > 0)) {
                                                // se llama a la función getIdArea, la cual obtiene el id del área.
                                                $idArea = $this->getIdArea($value['Area']);
                                                // si la variable  esta definida y no es null ni cero
                                                if (isset($idArea) && ($idArea > 0)) {
                                                    //se llama la funcion de getIdProject
                                                    $idProject = $this->getIdProject($value['nombre_proyecto']);
                                                    if (isset($idProject) && ($idProject > 0)) {
                                                        //se valida que todo esta bien
                                                        $result = "Ok";
                                                    } else {
                                                        $result = '512 Error: el proyecto ' . $value['nombre_proyecto'] . ' No es valida.';
                                                        $this->insertEventLog($result, 1);
                                                        break;
                                                    }
                                                } else {
                                                    // mensaje de error si en la base de datos no existe esta llave foranea con esos datos
                                                    $result = '502 Error: el Area ' . $value['Area'] . ' No es valida.';
                                                    $this->insertEventLog($result, 1);
                                                    break;
                                                }
                                            } else {
                                                // mensaje de error si en la base de datos no existe esta llave foranea con esos datos
                                                $result = '503 Error: El codigo_dispositivo ' . $value['codigo_dispositivo'] . ' No es valido.';
                                                $this->insertEventLog($result, 1);
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }

    // this function get device id
    private function getIdDevice($codDevice)
    {
        $devId = 0;
        // consulta donde el dispositivo sea igual el nombre y este activo y la fecha de eliminacion sea null
        $deviceId = Device::select('id')
            ->where('device_code', $codDevice)
            ->where('state', 1)
            ->where('deleted_at', null)
            ->get();
        // si la colección $deviceId, es mayor a 0, es porque el dispositivo encontrado es valido.
        if (count($deviceId) > 0) {
            // ciclo para obtener el id del dispositivo
            foreach ($deviceId as $codVar) {
                $devId = $codVar->id;
            }
        }
        // devolver el id
        return $devId;
    }

    private function getIdArea($codArea)
    {
        // variable que recorrera el json
        $AId = 0;
        $areaId = Area::Select('id')
            ->where('name', $codArea)
            ->where('deleted_at', null)
            ->get();
        // si la colección $areaId, es mayor a 0, es porque el área encontrada es valido.
        if (count($areaId) > 0) {
            // ciclo para obtener el id del area
            foreach ($areaId as $codeArea) {
                $AId = $codeArea->id;
            }
        }
        // devolver el id
        return $AId;
    }

    private function getIdProject($codProject)
    {
        $projId = Project::Select('id')
            ->where('name', $codProject)
            ->where('deleted_at', null)
            ->get();

        if (count($projId) > 0) {
            foreach ($projId as  $project) {
                $projId = $project->id;
            }
        }

        return $projId;
    }

    // funcion para insertar
    private function insertLocation($inRequest)
    {
        try {
            // asignamos los valores a la varible $locatingData desde $inRequest
            $locatingData = $inRequest->input();
            foreach ($locatingData as $key => $value) {
                // hacemos referencia al objeto de la tabla en la cual se insertará
                $objLocation = new LocationDevice();

                $objLocation->address = $value['Direccion'];
                $objLocation->installation_date = $value['Fecha_ins'];
                $objLocation->installation_hour = $value['Hora_ins'];
                $objLocation->latitude = (float)$value['Latitud'];
                $objLocation->length = (float)$value['Longitud'];
                $objLocation->device_id = $this->codeDevice;
                $objLocation->area_id = $this->getIdArea($value['Area']);
                $objLocation->project_id = $this->getIdProject($value['nombre_proyecto']);

                $objLocation->save();
            }
        } catch (\Throwable $th) {
            return 501;
        }
        return 200;
    }



    /*------------------------------------------------------------------------------------------------------------*/


    public function locationUpdate(Request $request)
    {
        if ($request->isMethod('put')) {
            // se llama a la función validateJsonRemove, para validar la integridad de los datos.
            $result = $this->validateJsonRemove($request);
            if ($result == "Ok") {
                // se llama a la función updateLocation, quien realizará la actualización sobre la B. de D.
                $updateResult = $this->updateLocation($request);
                if ($updateResult == "200") {
                    return $this->sendResponse(200, 'Ok');
                } elseif ($updateResult == "512") {
                    $this->insertEventLog("512 Error: El Dispositivo ya ha sido removido", 2);
                    return  $this->sendResponse(512, 'Error: El Dispositivo ya ha sido removido.');
                } else {
                    $this->insertEventLog("501 Error: Al ingresar los datos sobre la Base de Datos", 2);
                    return $this->sendResponse(501, 'Error: Al ingresar los datos sobre la Base de Datos');
                }
            } else {
                $reply = substr($result, 0, 3);
                switch ($reply) {
                    case '503':
                        return $this->sendResponse(503, $result);
                        break;
                    case '510':
                        return $this->sendResponse(510, $result);
                        break;
                    case '511':
                        return $this->sendResponse(511, $result);
                        break;
                }
            }
        }
    }

    private function validateJsonRemove($location)
    {
        $result = "";
        $locationRules = $location->input();
        foreach ($locationRules as  $value) {
            if (empty($value['codigo_dispositivo'])) {
                $result = '510 Error: No hay dato en codigo_dispositivo';
                $this->insertEventLog($result, 2);
                break;
            } else {
                if (empty($value['Fecha_ret'])) {
                    $result = '511 Error: No hay dato en Fecha_ret';
                    $this->insertEventLog($result, 2);
                    break;
                } else {
                    $this->codeDevice =  $this->getIdDevice($value['codigo_dispositivo']);
                    if (isset($this->codeDevice) && ($this->codeDevice > 0)) {
                        $result = "Ok";
                    } else {
                        $result = '503 Error: El codigo_dispositivo ' . $value['codigo_dispositivo'] . ' No es valido.';
                        $this->insertEventLog($result, 2);
                        break;
                    }
                }
            }
        }
        return $result;
    }

    // This function, update the "remove_date" in the table "LocationDevice".
    private function updateLocation($inRequest)
    {
        $iddevice = 0;
        $result = "200";
        try {
            $objLocation = LocationDevice::select('id')
                ->where('device_id', $this->codeDevice)
                ->whereNull('remove_date')
                ->get();
            if (count($objLocation) > 0) {
                foreach ($objLocation as $objloc) {
                    $iddevice = $objloc->id;
                }
                $removeDate = $inRequest->input();
                foreach ($removeDate as $value) {
                    $objLocation = LocationDevice::find($iddevice);
                    $objLocation->remove_date = $value['Fecha_ret'];
                    $objLocation->update();
                }
            } else {
                $result = "512";
            }
        } catch (\Throwable $th) {
            $result = "501";
            return $result;
        }
        return $result;
    }

    /**
     * This function save the event logs
     */
    private function insertEventLog($description, $eventType): void
    {
        try {
            $dateEvent = Carbon::now()->toDateTimeString();

            $et = "";

            if ($eventType == 1) {
                $et = "Register Location Device";
            } else {
                $et = "Register Remove Device";
            }

            EventLog::insert([
                'date_event' => $dateEvent,
                'type_event' => $et,
                'description' => $description,
                'created_at' => $dateEvent,
                'updated_at' => $dateEvent
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

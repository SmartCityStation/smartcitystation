<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateDeviceRequest;
use App\Http\Requests\Backend\UpdateDeviceRequest;
use App\Repositories\Backend\DeviceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
// use App\DTO\Device;
use App\Models\Frontend\Measure;
use App\Models\Backend\VariableDevice;
use App\Models\Backend\Device;
use App\Models\Backend\LocationDevice;
use App\Models\Backend\Project;

class DeviceController extends AppBaseController
{
    /** @var  DeviceRepository */
    private $deviceRepository;

    public function __construct(DeviceRepository $deviceRepo)
    {
        $this->deviceRepository = $deviceRepo;
    }

    /**
     * Display a listing of the Device.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $devices = $this->deviceRepository->paginate(5);

        return view('backend.devices.index')
            ->with('devices', $devices);
    }

    /**
     * Show the form for creating a new Device.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.devices.create');
    }

    /**
     * Store a newly created Device in storage.
     *
     * @param CreateDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateDeviceRequest $request)
    {

        $state = 0;
        if ($request->state == "active") {
            $state = 1;
        } else {
            $state = 2;
        }

        $input = [
            'device_code' => $request->device_code,
            'state' => $state,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // $input = $request->all();

        try {
            $device = $this->deviceRepository->create($input);
            Flash::success('Dispositivo Guardado con Exito.');
        } catch (\Throwable $th) {
            // throw $th;
            Flash::error(__('The Device Code already exists'));
        }

        return redirect(route('admin.devices.index'));
    }

    /**
     * Display the specified Device.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        return view('backend.devices.show')->with('device', $device);
    }

    /**
     * Show the form for editing the specified Device.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        return view('backend.devices.edit')->with('device', $device);
    }

    /**
     * Update the specified Device in storage.
     *
     * @param int $id
     * @param UpdateDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeviceRequest $request)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        $state = 0;
        if ($request->state == "active") {
            $state = 1;
        } else {
            $state = 2;
        }

        $input = [
            'device_code' => $request->device_code,
            'state' => $state,
            'created_at' =>  $request->created_at,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $device->device_code = $input['device_code'];
            $device->state = $input['state'];
            $device->created_at = $input['created_at'];
            $device->created_at = $input['updated_at'];

            $device->save();

            // $device = $this->deviceRepository->update($request->all(), $id);

            Flash::success('Dispositivo Actualizado con Exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success(__('The Device Code already exists'));
        }

        return redirect(route('admin.devices.index'));
    }

    /**
     * Remove the specified Device from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        // Before start with delete, is necesary verify is the device has send measures.
        try {
            $measures = Measure::where('device_id', $id)->first();
        } catch (\Throwable $th) {
            $measures = "";
        }

        if (!empty($measures) || $measures != "") {
            Flash::error(__('The device Can´t to be delete, because it has measures'));

            return redirect(route('admin.devices.index'));
        }

        //Now is necesary delete the variables associates with device.
        try {
            $variablesDevice = VariableDevice::where('device_id', $id)->first();
        } catch (\Throwable $th) {
            $variablesDevice = "";
        }

        if (!empty($variablesDevice) || $variablesDevice != "") {
            VariableDevice::where('device_id', $id)->forceDelete();    // physical delete.
        }

        // Now is necesary delete location device associates with device.
        try {
            $locationDevice = LocationDevice::where('device_id', $id)->first();
        } catch (\Throwable $th) {
            $locationDevice = "";
        }

        if (!empty($locationDevice) || $locationDevice != "") {
            LocationDevice::where('device_id', $id)->forceDelete();    // physical delete.
        }

        $device = Device::find($id);
        $device->forceDelete();   // physical delete.

        // $device->delete();  // Logic delete, this is for softdelete
        // $this->deviceRepository->delete($id);  // Logic delete, this is for softdelete

        Flash::success('Device deleted successful');

        return redirect(route('admin.devices.index'));
    }

    public function getDeviceProject(Request $request)
    {
        $input = $request->all();
        $idproject = $input['projectid'];

        $device = LocationDevice::join('devices', 'devices.id', '=', 'location_devices.device_id')
        ->where('location_devices.project_id', $idproject)
        ->select('devices.id','devices.device_code')
        ->get();

        $device_json = $device->toJson();

        return $device_json;
    }
}

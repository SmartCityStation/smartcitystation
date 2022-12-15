<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateLocationDeviceRequest;
use App\Http\Requests\Backend\UpdateLocationDeviceRequest;
use App\Repositories\Backend\LocationDeviceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Backend\Device;
use App\Models\Backend\Area;
use App\Models\Backend\LocationDevice;
use App\Models\Backend\Project;
use App\Models\Backend\Sector;
use App\Models\Backend\Subsector;

class LocationDeviceController extends AppBaseController
{
    /** @var  LocationDeviceRepository */
    private $locationDeviceRepository;

    public function __construct(LocationDeviceRepository $locationDeviceRepo)
    {
        $this->locationDeviceRepository = $locationDeviceRepo;
    }

    /**
     * Display a listing of the LocationDevice.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $locationDevices = $this->locationDeviceRepository->paginate(5);

        return view('backend.location_devices.index')
            ->with('locationDevices', $locationDevices);
    }

    /**
     * Show the form for creating a new LocationDevice.
     *
     * @return Response
     */
    public function create()
    {
        $devices = Device::pluck('device_code', 'id');
        $areas = Area::pluck('name', 'id');
        $projects = Project::pluck('name', 'id');

        $subsectors = Subsector::select('subsectors.description', 'subsectors.id as subsecId', 'sectors.name', 'alert_threshold_day', 'alert_threshold_night')
            ->join('sectors', 'sectors.id', '=', 'subsectors.sector_id')
            ->paginate(5);

        $desde = "Create";

        return view('backend.location_devices.create')->with(compact('devices', 'areas', 'desde', 'projects', 'subsectors'));
    }

    /**
     * Store a newly created LocationDevice in storage.
     *
     * @param CreateLocationDeviceRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        try {
            // $LocationDevice = new LocationDevice;

            // $LocationDevice->address =  $request->address;
            // $LocationDevice->installation_date =  $request->installation_date;
            // $LocationDevice->installation_hour =  $request->installation_hour;
            // $LocationDevice->remove_date =  null;
            // $LocationDevice->latitude =  $request->latitude;
            // $LocationDevice->length =  $request->length;
            // $LocationDevice->device_id =  $request->device_id;
            // $LocationDevice->area_id =  $request->area_id;
            // $LocationDevice->project_id = $request->project_id;
            // $LocationDevice->subsector_id = intval($request->subsector_id);
            // $LocationDevice->save();

            LocationDevice::create([
                'address' => $request->address,
                'installation_date' => $request->installation_date,
                'installation_hour' => $request->installation_hour,
                'remove_date' => null,
                'latitude' => $request->latitude,
                'length' => $request->length,
                'device_id' => $request->device_id,
                'area_id' => $request->area_id,
                'project_id' => $request->project_id,
                'subsector_id' => intval($request->subsector_id),

            ]);

            Flash::success('Ubicación del Dispositivo guardado con Exito.');
        } catch (\Throwable $th) {
            // throw $th;
            Flash::error('Error to save Location Device');
        }

        return redirect(route('admin.locationDevices.index'));
    }

    /**
     * Display the specified LocationDevice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('admin.locationDevices.index'));
        }

        return view('backend.location_devices.show')->with('locationDevice', $locationDevice);
    }

    /**
     * Show the form for editing the specified LocationDevice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $devices = Device::pluck('device_code', 'id');
        $areas = Area::pluck('name', 'id');
        $projects = Project::pluck('name', 'id');
        $subsectors = Subsector::select('subsectors.description', 'subsectors.id as subsecId', 'sectors.name', 'alert_threshold_day', 'alert_threshold_night')
            ->join('sectors', 'sectors.id', '=', 'subsectors.sector_id')
            ->paginate(5);

        $subsectorEdit = LocationDevice::select('subsector_id')
            ->where('id', $id)->first();

        $desde = "Edit";

        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('admin.locationDevices.index'));
        }

        session(['removeDate' => $locationDevice->remove_date]);  // Set, Session Variable

        return view('backend.location_devices.edit')->with(compact('locationDevice', 'devices', 'areas', 'desde', 'projects', 'subsectors', 'subsectorEdit'));
    }

    /**
     * Update the specified LocationDevice in storage.
     *
     * @param int $id
     * @param UpdateLocationDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationDeviceRequest $request)
    {

        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('admin.locationDevices.index'));
        }

        /* Before of continue, the dates are validate */
        if (isset($request->remove_date)) {
            if (!$this->validate_dates($request->installation_date, $request->remove_date)) {

                Flash::error('The withdrawal date cannot be less than or equal to the date of installation.');

                return redirect(route('admin.locationDevices.index'));
            }
        }

        $locationDevice->address =  $request->address;

        if (isset($request->installation_date) && isset($request->installation_hour)) {
            $locationDevice->installation_date =  $request->installation_date;
            $locationDevice->installation_hour =  $request->installation_hour;
        }

        if ($request->remove_date == null) {
            $locationDevice->remove_date =  session('removeDate');  // Get, Session Variable
        } else {
            $locationDevice->remove_date =  $request->remove_date;
        }

        $locationDevice->latitude =  $request->latitude;
        $locationDevice->length =  $request->length;
        $locationDevice->device_id =  $request->device_id;
        $locationDevice->area_id =  $request->area_id;
        $locationDevice->project_id = $request->project_id;
        $locationDevice->subsector_id = intval($request->subsector_id);
        $locationDevice->created_at =  $request->created_at;
        $locationDevice->updated_at =  $request->updated_at;

        $locationDevice->save();

        // $locationDevice = $this->locationDeviceRepository->update($request->all(), $id);

        Flash::success('Ubicacion de Dispositivo Actualizado con Exito.');

        return redirect(route('admin.locationDevices.index'));
    }

    /**
     * Remove the specified LocationDevice from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('admin.locationDevices.index'));
        }

        // Before of delete, verify that the the device with location not have measures.
        $locationDeviceHasMeasures = Device::select('location_devices.id', 'location_devices.address', 'devices.device_code', 'measures.data')
            ->join('location_devices', 'devices.id', '=', 'location_devices.device_id')
            ->leftJoin('measures', 'devices.id', '=', 'measures.device_id')
            ->where('location_devices.id', '=', $id)
            ->get();

        if (count($locationDeviceHasMeasures) > 0) {
            $erase = false;
            foreach ($locationDeviceHasMeasures as $locationDeviceHasMeasure) {
                if ($locationDeviceHasMeasure->data != null) {
                    $erase = true;
                    break;
                }
            }

            if ($erase == true) {
                Flash::error(__('The location Can´t be deleated, because the device has measures associated'));
                return redirect(route('admin.locationDevices.index'));
            }

            $type_variable = LocationDevice::find($id);
            $type_variable->forceDelete();   // physical delete.

            // $this->locationDeviceRepository->delete($id);    // Logic delete, this is for softdelete

            Flash::success('Location Device deleted successful');

            return redirect(route('admin.locationDevices.index'));
        }

        Flash::error('Location Device not found');
        return redirect(route('admin.locationDevices.index'));
    }


    /*
        This function validate that, the removing date is greater than the installing date.
    */
    private function validate_dates($dateInstall, $dateRemove)
    {

        $diffDate = true;

        $ts1 = strtotime($dateInstall);
        $ts2 = strtotime($dateRemove);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $day1 = date('d', $ts1);
        $day2 = date('d', $ts2);

        if ($year2 < $year1) {
            $diffDate = false;
        } elseif ($month2 < $month1) {
            $diffDate = false;
        } elseif ($day2 <= $day1) {
            $diffDate = false;
        }

        return $diffDate;
    }
}

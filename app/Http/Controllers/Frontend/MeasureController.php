<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\CreateMeasureRequest;
use App\Http\Requests\Frontend\UpdateMeasureRequest;
use App\Repositories\Frontend\MeasureRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Backend\Device;
use App\Models\Backend\DataVariable;
use App\Models\Frontend\Measure;
use App\DTO\Collection;
use App\DTO\MeasureObject;
use App\Exports\MeasuresExport;
use App\Mail\sendEmailNew;
use App\Models\Backend\LocationDevice;
use App\Models\Backend\Project;
use Carbon\Carbon;
use DB;
//esta librería se usa para crear archivos de excel
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class MeasureController extends AppBaseController
{
    private $collectionMeasuresDate;

    /** @var  MeasureRepository */
    private $measureRepository;

    public function __construct(MeasureRepository $measureRepo)
    {
        $this->measureRepository = $measureRepo;
    }

    /**
     * Display a listing of the Measure.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $measures = $this->measureRepository->all();

        return view('frontend.measures.index')
            ->with('measures', $measures);
    }

    /**
     * Show the form for creating a new Measure.
     *
     * @return Response
     */
    public function create()
    {
        $devices = Device::pluck('device_code', 'id');
        $dataVariables = DataVariable::pluck('name', 'id');

        return view('frontend.measures.create')->with(compact('devices', 'dataVariables'));
        // return view('frontend.measures.create');
    }

    /**
     * Store a newly created Measure in storage.
     *
     * @param CreateMeasureRequest $request
     *
     * @return Response
     */
    public function store(CreateMeasureRequest $request)
    {
        $input = $request->all();

        $measure = $this->measureRepository->create($input);

        Flash::success('Medidas Guardado con Exito.');

        return redirect(route('frontend.measures.index'));
    }

    /**
     * Display the specified Measure.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        return view('frontend.measures.show')->with('measure', $measure);
    }

    /**
     * Show the form for editing the specified Measure.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $devices = Device::pluck('device_code', 'id');
        $dataVariables = DataVariable::pluck('name', 'id');

        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        return view('frontend.measures.edit')->with(compact('measure', 'devices', 'dataVariables'));
        // return view('frontend.measures.edit')->with('measure', $measure);
    }

    /**
     * Update the specified Measure in storage.
     *
     * @param int $id
     * @param UpdateMeasureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMeasureRequest $request)
    {
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        $measure = $this->measureRepository->update($request->all(), $id);

        Flash::success('Medidas Actualizado con Exito.');

        return redirect(route('frontend.measures.index'));
    }

    /**
     * Remove the specified Measure from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        $this->measureRepository->delete($id);

        Flash::success('Medida Eliminado con Exito.');

        return redirect(route('frontend.measures.index'));
    }

    public function measureIndex(Request $request)
    {
        return view('frontend.measures.query_measure');
    }

    /**
     * This main function, for get the measures data:
     */
    public function showMeasures(Request $request)
    {
        $input = $request->all();
        $variable = $input['variable'];
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $device = $input['device'];
        $typeVar = $input['typeVar'];
        $startTime = $input['startTime'];
        $endTime = $input['endTime'];

        $Measures_json = '';

        if ($startDate == $endDate) {

            if (($startTime == '00:00:00') && ($endTime == '00:00:00')) {
                $startTime = '00:00:01';
                $endTime = '23:59:59';
            }

            $measuresDay = $this->getMeasuresDay($variable, $startDate, $startTime, $endTime, $device);

            if (count($measuresDay) > 0) {

                if ($typeVar == 2) {
                    $this->getAverageSameDayEnvironment($measuresDay);
                } else {
                    $this->getAverageSameDay($measuresDay);
                }

                $Measures_json = json_encode($measuresDay);  // de Objeto a JSON. 
            }
        } else {

            $measuresDate = $this->getMeasuresDate($variable, $startDate, $endDate, $device);

            if (isset($measuresDate)) {
                $diffMonth = $this->diff_Month($startDate, $endDate);
                if ($diffMonth == 0) {
                    if ($typeVar == 2) {
                        $this->getAverageForDayEnvironment($measuresDate);
                    } else {
                        $this->getAverageForDay($measuresDate);
                    }
                } elseif (($diffMonth > 0) && ($diffMonth < 13)) {
                    if ($typeVar == 2) {
                        $this->getAverageForMonthsEnvironment($measuresDate);
                    } else {
                        $this->getAverageForMonths($measuresDate);
                    }
                } else {
                    if ($typeVar == 2) {
                        $this->getAverageForYearsEnvironment($measuresDate);
                    } else {
                        $this->getAverageForYears($measuresDate);
                    }
                }

                if (isset($this->collectionMeasuresDate) && !empty($this->collectionMeasuresDate)) {
                    $measuresFinal = (array)$this->collectionMeasuresDate;

                    $Measures_json = json_encode($measuresFinal);  // de Odjeto a JSON.

                    $Measures_json = substr($Measures_json, 40);
                    $Measures_json = substr($Measures_json, 0, -1);

                    // } elseif (!isset($measuresDate) && !isset($measuresDay)) {
                } elseif (!isset($measuresDate)) {
                    $response = (array)[];
                    $Measures_json = json_encode($response);  // de Odjeto a JSON.
                }
            } else {
                $response = (array)[];
                $Measures_json = json_encode($response);  // de Odjeto a JSON.           
            }
        }

        return $Measures_json;
    }

    /*
        This function take the id variable, start date, start time and end time, 
        return the collection of measures of day.
    */
    private function getMeasuresDay($variable, $startDate, $startTime, $endTime, $device)
    {
        $Measures = DB::select('CALL SP_GetMeasuresSameDay (?, ?, ?, ?, ?)', array($variable, $startDate, $startTime, $endTime, $device));
        return $Measures;
    }

    private function getMeasuresDate($idVar, $startDate, $endDate, $device)
    {
        $Measures = DB::select('CALL SP_GetMeasures (?, ?, ?, ?)', array($idVar, $startDate, $endDate, $device));

        return $Measures;
    }


    //metodo de exportación de datos en excel
    public function exportMeasures(Request $request)
    {
        $input = $request->all();

        $TypeVariable = $input['variable'];
        $variable = $input['dataVariable'];
        $startDate = $input['dateFrom'];
        $endDate = $input['dateTo'];
        $project = $input['project'];

        //se mandan las variables a la colección export measure.
        return Excel::download(new MeasuresExport($TypeVariable, $variable, $startDate, $endDate, $project), 'measures.xlsx');
    }

    public function getAverageSameDayEnvironment($measuresDate): void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;

        foreach ($measuresDate as $measureDate) {
            $sumData = $measureDate->data;
            $sumData = number_format($sumData, 2);
            $sumData = (float)$sumData;

            $measure = new MeasureObject($measureDate->time, $sumData);
            $this->collectionMeasuresDate->add($measure);
        }
    }

    public function getAverageForDayEnvironment($measuresDate): void
    {

        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxDay = '';

        foreach ($measuresDate as $measureDate) {
            $components = preg_split("[-]", $measureDate->time);
            if ($contData == 0) {
                $auxDay = substr($components[2], 0, 2);
            } elseif (substr($components[2], 0, 2) != $auxDay) {

                $average = ($sumData / $contData);
                $average = number_format($average, 2);
                $average = (float)$average;


                $measure = new MeasureObject($auxDay, $average);
                $this->collectionMeasuresDate->add($measure);

                $sumData = 0;
                $contData = 0;
                $auxDay = substr($components[2], 0, 2);
            }

            $sumData += $measureDate->data;
            $contData++;
        }

        $average = ($sumData / $contData);
        $average = number_format($average, 2);
        $average = (float)$average;

        $measure = new MeasureObject($auxDay, $average);

        $this->collectionMeasuresDate->add($measure);
    }

    public function getAverageForMonthsEnvironment($measuresDate): void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxMonth = '';

        foreach ($measuresDate as $measureDate) {
            $components = preg_split("[-]", $measureDate->time);
            if ($contData == 0) {
                $auxMonth = substr($components[1], 0, 2);
            } elseif (substr($components[1], 0, 2) != $auxMonth) {

                $average = ($sumData / $contData);
                $average = number_format($average, 2);
                $average = (float)$average;

                $measure = new MeasureObject($auxMonth, $average);
                $this->collectionMeasuresDate->add($measure);

                $sumData = 0;
                $contData = 0;
                $auxMonth = substr($components[1], 0, 2);
            }
            $sumData += $measureDate->data;
            $contData++;
        }

        $average = ($sumData / $contData);
        $average = number_format($average, 2);
        $average = (float)$average;

        $measure = new MeasureObject($auxMonth, $average);
        $this->collectionMeasuresDate->add($measure);
    }

    public function getAverageForYearsEnvironment($measuresDate): void
    {

        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxYears = '';

        foreach ($measuresDate as $measureDate) {
            $components = preg_split("[-]", $measureDate->time);

            if ($contData == 0) {
                $auxYears = substr($components[0], 0, 4);
            } elseif (substr($components[0], 0, 4) != $auxYears) {
                $average = ($sumData / $contData);
                $average = number_format($average, 2);
                $average = (float)$average;

                $measure = new MeasureObject($auxYears, $average);
                $this->collectionMeasuresDate->add($measure);

                $sumData = 0;
                $contData = 0;
                $auxYears = substr($components[0], 0, 4);
            }

            $sumData += $measureDate->data;
            $contData++;
        }
        $average = ($sumData / $contData);
        $average = number_format($average, 2);
        $average = (float)$average;

        $measure = new MeasureObject($auxYears, $average);
        $this->collectionMeasuresDate->add($measure);
    }

    /*
        This function take the id variable, start date, and end date, 
        return the collection of measures for a range dates.
    */

    /*
        This function take two dates and return their difference in month.
    */
    private function diff_Month($dateOne, $dateTwo)
    {
        $diffMonth = 0;

        $ts1 = strtotime($dateOne);
        $ts2 = strtotime($dateTwo);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        if (($year2 == $year1) && ($month2 == $month1)) {
            $diffMonth = (($year2 - $year1) * 12) + ($month2 - $month1);
        } elseif (($year2 == $year1) && ($month2 > $month1)) {
            $diffMonth = $month2 - $month1;
        } elseif ($year2 > $year1) {
            $diffMonth = ($year2 - $year1) + 12;
        }

        return $diffMonth;
    }

    /*
        This function push the objects with the average same day.
    */
    private function getAverageSameDay($measuresDate): void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $auxDay = '';

        foreach ($measuresDate as $measureDate) {
            // $sumData += 10 ** ($measureDate->data / 10);
            $sumData = $measureDate->data;
            $sumData = number_format($sumData, 2);
            $sumData = (float)$sumData;

            $measure = new MeasureObject($measureDate->time, $sumData);
            $this->collectionMeasuresDate->add($measure);
        }
    }

    /*
        This function push the objects with the average for days.
    */
    private function getAverageForDay($measuresDate): void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxDay = '';

        foreach ($measuresDate as $measureDate) {
            $components = preg_split("[-]", $measureDate->time);

            if ($contData == 0) {
                $auxDay = substr($components[2], 0, 2);
            } elseif (substr($components[2], 0, 2) != $auxDay) {
                $average = 10 * (log10($sumData / $contData));
                $average = number_format($average, 2);
                $average = (float)$average;

                $measure = new MeasureObject($auxDay, $average);

                $this->collectionMeasuresDate->add($measure);

                $sumData = 0;
                $contData = 0;
                $auxDay = substr($components[2], 0, 2);
            }

            $sumData += 10 ** ($measureDate->data / 10);
            $contData += 1;
        }
        $average = 10 * (log10($sumData / $contData));
        $average = number_format($average, 2);
        $average = (float)$average;

        $measure = new MeasureObject($auxDay, $average);

        $this->collectionMeasuresDate->add($measure);
    }

    /*
        This function push the objects with the average for months.
    */
    private function getAverageForMonths($measuresDate): void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxMonth = '';

        foreach ($measuresDate as $measureDate) {
            $components = preg_split("[-]", $measureDate->time);

            if ($contData == 0) {
                $auxMonth = substr($components[1], 0, 2);
            } elseif (substr($components[1], 0, 2) != $auxMonth) {
                $average = 10 * (log10($sumData / $contData));
                $average = number_format($average, 2);
                $average = (float)$average;

                $measure = new MeasureObject($auxMonth, $average);
                $this->collectionMeasuresDate->add($measure);

                $sumData = 0;
                $contData = 0;
                $auxMonth = substr($components[1], 0, 2);
            }
            $sumData += 10 ** ($measureDate->data / 10);
            $contData += 1;
        }
        $average = 10 * (log10($sumData / $contData));
        $average = number_format($average, 2);
        $average = (float)$average;

        $measure = new MeasureObject($auxMonth, $average);
        $this->collectionMeasuresDate->add($measure);
    }

    /*
        This function push the objects with the average for years.
    */
    private function getAverageForYears($measuresDate): void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxYears = '';

        foreach ($measuresDate as $measureDate) {
            $components = preg_split("[-]", $measureDate->time);

            if ($contData == 0) {
                $auxYears = substr($components[0], 0, 4);
            } elseif (substr($components[0], 0, 4) != $auxYears) {
                $average = 10 * (log10($sumData / $contData));
                $average = number_format($average, 2);
                $average = (float)$average;

                $measure = new MeasureObject($auxYears, $average);
                $this->collectionMeasuresDate->add($measure);

                $sumData = 0;
                $contData = 0;
                $auxYears = substr($components[0], 0, 4);
            }
            $sumData += 10 ** ($measureDate->data / 10);
            $contData += 1;
        }
        $average = 10 * (log10($sumData / $contData));
        $average = number_format($average, 2);
        $average = (float)$average;

        $measure = new MeasureObject($auxYears, $average);
        $this->collectionMeasuresDate->add($measure);
    }

    //This function valid that data variable doesn`t exceed the treshold 
    // private function lookinForAlertEachMinute(): void
    public function lookinForAlertEachMinute()
    {
        $hora = Carbon::now("America/Bogota")->subminutes(1);
        $fecha = Carbon::now("America/Bogota");      

        $projects = Project::join('users', 'users.id', '=', 'projects.user_id')
        ->where('start_date', '<=', $fecha)
        ->where('end_date', '>=', $fecha)
        ->select('users.email', 'projects.id')
        ->get();

        foreach ($projects as $project) {
            $measuresAlerts = array();

            $device = locationDevice::join('devices', 'devices.id', '=', 'location_devices.device_id')
            ->where('location_devices.project_id', '=', $project->id)
            ->select('devices.device_code AS device')
            ->first();

            $subsector = locationDevice::join('subsectors', 'subsectors.id', '=', 'location_devices.subsector_id')
            ->join('sectors', 'sectors.id', '=', 'subsectors.sector_id')
            ->where('location_devices.project_id', '=', $project->id)
            ->select('sectors.name AS sector')
            ->first();


            //Consulta que trae los datos con un minuto de diferencia
            $getMeasures = LocationDevice::join('devices', 'devices.id', '=', 'location_devices.device_id')
                ->join('measures', 'measures.device_id', '=', 'devices.id')
                ->join('data_variables', 'data_variables.id', '=', 'measures.data_variable_id')
                ->where('data_variables.name', '=', 'LAeq')
                ->where('location_devices.project_id', '=', $project->id)
                ->where('measures.time', '>', $hora)
                ->select('location_devices.device_id AS device_id', 'measures.data', 'measures.time', 'data_variables.name AS data_variable', 'devices.device_code AS device')
                ->get();
       
            foreach ($getMeasures as $measure) {
               
                if (substr($measure->time, 11, 8) >= "00:00:00" && substr($measure->time, 11, 8) <= "18:00:00") {

                    $alertVariable = LocationDevice::select('subsectors.alert_threshold_day')
                        ->join('subsectors', 'subsectors.id', '=', 'location_devices.subsector_id')
                        ->where('subsectors.alert_threshold_day', '<', $measure->data)
                        ->where('location_devices.device_id', $measure->device_id)
                        ->get();

                    if (count($alertVariable) > 0) {
                        foreach ($alertVariable as $alert) {
                            $alertVar = $alert->alert_threshold_day;
                            $diff = $measure->data - $alertVar;
                            array_push($measuresAlerts, array($measure->device, $measure->time, $measure->data_variable, $measure->data, $alertVar, $diff));
                        }
                    }

                } else {

                    $alertVariable = LocationDevice::select('subsectors.alert_threshold_night')
                        ->join('subsectors', 'subsectors.id', '=', 'location_devices.subsector_id')
                        ->where('subsectors.alert_threshold_night', '<', $measure->data)
                        ->where('location_devices.device_id', $measure->device_id)
                        ->get();

                    if (count($alertVariable) > 0) {
                        foreach ($alertVariable as $alert) {
                            $alertVar = $alert->alert_threshold_night;
                            $diff = $measure->data - $alertVar;
                            array_push($measuresAlerts, array($measure->device, $measure->time, $measure->data_variable, $measure->data, $alertVar, $diff));
                        }
                    }

                }
            }
            
            if(count($measuresAlerts) > 0) {
                $this->userEmail($project->email, $measuresAlerts, $device, $subsector);
            }
        }

    }

    /**
     * this function send email towards the mailabler sendEmailNew.php, send global variable 
     */

    private function userEmail($email, $measuresAlerts, $device, $subsector)
    {
        Mail::to($email)->send(new sendEmailNew($measuresAlerts, $device, $subsector));
    }
}

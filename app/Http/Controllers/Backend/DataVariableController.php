<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateDataVariableRequest;
use App\Http\Requests\Backend\UpdateDataVariableRequest;
use App\Repositories\Backend\DataVariableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Backend\Type_variable;
use App\Models\Backend\DataVariable;
use App\Models\Backend\Project;
use App\Models\Backend\ProjectVariable;
use App\Models\Backend\VariableDevice;
use App\Models\Frontend\Measure;

class DataVariableController extends AppBaseController
{
    /** @var  DataVariableRepository */
    private $dataVariableRepository;

    public function __construct(DataVariableRepository $dataVariableRepo)
    {
        $this->dataVariableRepository = $dataVariableRepo;
    }

    /**
     * Display a listing of the DataVariable.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dataVariables = $this->dataVariableRepository->paginate(5);

        return view('backend.data_variables.index')
            ->with('dataVariables', $dataVariables);
    }

    /**
     * Show the form for creating a new DataVariable.
     *
     * @return Response
     */
    public function create()
    {
        $typeVariables = Type_variable::pluck('name', 'id');
        return view('backend.data_variables.create', compact('typeVariables'));
    }

    /**
     * Store a newly created DataVariable in storage.
     *
     * @param CreateDataVariableRequest $request
     *
     * @return Response
     */
    public function store(CreateDataVariableRequest $request)
    {
        $input = $request->all();

        try {
            $dataVariable = $this->dataVariableRepository->create($input);

            Flash::success('Datos de la Variable Guardado con Exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::error(__('Error: already a varible with this name'));
        }

        return redirect(route('admin.dataVariables.index'));
    }

    /**
     * Display the specified DataVariable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        return view('backend.data_variables.show')->with('dataVariable', $dataVariable);
    }

    /**
     * Show the form for editing the specified DataVariable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $typeVariables = Type_variable::pluck('name', 'id');

        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        return view('backend.data_variables.edit')->with(compact('dataVariable', 'typeVariables'));
        // return view('backend.data_variables.edit')->with('dataVariable', $dataVariable);
    }

    /**
     * Update the specified DataVariable in storage.
     *
     * @param int $id
     * @param UpdateDataVariableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDataVariableRequest $request)
    {
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        try {
            $dataVariable = $this->dataVariableRepository->update($request->all(), $id);

            Flash::success('Datos de Variable Actualizado con Exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success(__('Error: already a varible with this name or error to conect with database'));
        }

        return redirect(route('admin.dataVariables.index'));
    }

    /**
     * Remove the specified DataVariable from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        $dataIsInDevicesMeasures = DataVariable::select('data_variables.name', 'variable_devices.device_id', 'measures.data')
            ->leftJoin('variable_devices', 'data_variables.id', '=', 'variable_devices.data_variable_id')
            ->leftJoin('measures', 'data_variables.id', '=', 'measures.data_variable_id')
            ->where('data_variables.id', '=', $id)
            ->get();

        if (count($dataIsInDevicesMeasures) > 0) {
            $erase = false;
            foreach ($dataIsInDevicesMeasures as $dataIsInDevicesMeasure) {
                if (($dataIsInDevicesMeasure->data != null) or ($dataIsInDevicesMeasure->device_id != null)) {
                    $erase = true;
                    break;
                }
            }

            if ($erase == true) {
                Flash::error(__('The data variable Can´t be deleated, because it has measures or devices associated'));
                return redirect(route('admin.dataVariables.index'));
            }

            $dataVariable = DataVariable::find($id);
            $dataVariable->forceDelete();   // physical delete.

            // $this->dataVariableRepository->delete($id);       // Logic delete, this is for softdelete

            Flash::success('data of variable deleted successful');
            return redirect(route('admin.dataVariables.index'));
        }

        Flash::error('Data Variable not found');
        return redirect(route('admin.dataVariables.index'));
    }

    /**
     *  This méthod, get the variable data tha to be equeal to id of type variable.
     */
    public function getVariableData(Request $request)
    {
        $input = $request->all();
        $variableTypeId = $input['variableTypeId'];
        $idproject = $input['projectid'];

        $variableData = ProjectVariable::select('data_variables.name', 'data_variables.id')
            ->join('data_variables', 'data_variables.id', '=', 'project_variables.data_variable_id')
            ->join('type_variables', 'type_variables.id', '=', 'data_variables.type_variable_id')
            ->where('project_id', $idproject)
            ->where('data_variables.type_variable_id', $variableTypeId)
            ->get();

        $variableData_json = $variableData->toJson(); 

        return $variableData_json;
    }
}

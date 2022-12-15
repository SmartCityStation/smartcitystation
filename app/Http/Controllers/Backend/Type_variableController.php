<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateType_variableRequest;
use App\Http\Requests\Backend\UpdateType_variableRequest;
use App\Repositories\Backend\Type_variableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

use App\Models\Backend\Type_variable;
use App\Models\Backend\DataVariable;
use App\Models\Backend\Project;
use App\Models\Backend\ProjectVariable;
use App\Models\Frontend\Measure;
use App\Models\Backend\VariableDevice;

class Type_variableController extends AppBaseController
{
    /** @var  Type_variableRepository */
    private $typeVariableRepository;

    public function __construct(Type_variableRepository $typeVariableRepo)
    {
        $this->typeVariableRepository = $typeVariableRepo;
    }

    /**
     * Display a listing of the Type_variable.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $typeVariables = $this->typeVariableRepository->paginate(5);

        return view('backend.type_variables.index')
            ->with('typeVariables', $typeVariables);
    }

    /**
     * Show the form for creating a new Type_variable.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.type_variables.create');
    }

    /**
     * Store a newly created Type_variable in storage.
     *
     * @param CreateType_variableRequest $request
     *
     * @return Response
     */
    public function store(CreateType_variableRequest $request)
    {
        $input = $request->all();

        try {
            $typeVariable = $this->typeVariableRepository->create($input);
            Flash::success('Variable Creada con exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::error(__('Error: already a varible type with this name or error to conect with database'));
        }

        return redirect(route('admin.typeVariables.index'));
    }

    /**
     * Display the specified Type_variable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        return view('backend.type_variables.show')->with('typeVariable', $typeVariable);
    }

    /**
     * Show the form for editing the specified Type_variable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        return view('backend.type_variables.edit')->with('typeVariable', $typeVariable);
    }

    /**
     * Update the specified Type_variable in storage.
     *
     * @param int $id
     * @param UpdateType_variableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateType_variableRequest $request)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        try {
            $typeVariable = $this->typeVariableRepository->update($request->all(), $id);

            Flash::success('Tipo de Variable actualizada con exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success(__('Error: already a varible type with this name or error to conect with database'));
        }

        return redirect(route('admin.typeVariables.index'));
    }

    /**
     * Remove the specified Type_variable from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        // Before of delete, verify that the variables associateds not have measures or devices.
        $resultQueriesOne = Type_variable::select('type_variables.id', 'data_variables.name', 'measures.data', 'variable_device.data_variable_id as datvarid')
            ->leftJoin('data_variables', 'type_variables.id', '=', 'data_variables.type_variable_id')
            ->leftJoin('measures', 'data_variables.id', '=', 'measures.data_variable_id')
            ->leftJoin('variable_devices', 'data_variables.id', '=', 'variable_devices.data_variable_id')
            ->where('type_variables.id', '=', $id)
            ->get();

        if (count($resultQueriesOne) > 0) {
            $erase = false;
            foreach ($resultQueriesOne as $resultQuerie) {
                if (($resultQuerie->data != null) or ($resultQuerie->device_id != null)) {
                    $erase = true;
                    break;
                }
            }

            if ($erase == true) {
                Flash::error(__('The type variable can´t be deleated, because it has measures or devices associated'));
                return redirect(route('admin.typeVariables.index'));
            }

            $hasVaribles = DataVariable::select('id')
                ->where('type_variable_id', $id)
                ->get();

            if (count($hasVaribles) > 0) {
                DataVariable::where('type_variable_id', $id)->forceDelete();      // physical delete.
            }

            $type_variable = Type_variable::find($id);
            $type_variable->forceDelete();   // physical delete.

            Flash::success('Type Variable deleted successful');
            return redirect(route('admin.typeVariables.index'));
        }

        // $this->typeVariableRepository->delete($id);    // Logic delete, this is for softdelete

        Flash::success('Type Variable not found');
        return redirect(route('admin.typeVariables.index'));
    }

    /**
     * This méthod, get the id and name of talbe Tipo_variable.
     */
    public function getVariableType()
    {
        $variablesType = Type_variable::select('id', 'name')
        ->orderBy('name')
        ->get();

        $variablesType_json = $variablesType->toJson();  // de Objeto a JSON.

        return $variablesType_json;
    }

    public function getVariableTypeForProj(Request $request)
    {
        $input = $request->all();
        $idproject = $input['projectid'];

    
        $variables = ProjectVariable::select('type_variables.id', 'type_variables.name')
            ->join('data_variables', 'data_variables.id', '=', 'project_variables.data_variable_id')
            ->join('type_variables', 'type_variables.id', '=', 'data_variables.type_variable_id')
            ->where('project_id', $idproject)
            ->groupBy('type_variables.name')
            ->get();

        $variablesProject_json = $variables->toJson();  // de Objeto a JSON.

        return $variablesProject_json;
    }
}

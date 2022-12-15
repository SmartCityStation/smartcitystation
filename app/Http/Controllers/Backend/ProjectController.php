<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProjectRequest;
use App\Http\Requests\Backend\UpdateProjectRequest;
use App\Models\Backend\DataVariable;
use App\Models\Backend\Device;
use App\Models\Backend\LocationDevice;
use App\Models\Backend\Project;
use App\Models\Backend\ProjectVariable;
use App\Models\Backend\Type_variable;
use App\Repositories\Backend\ProjectRepository;
use Carbon\Carbon;
use DB;
use Flash;
use Illuminate\Http\Request;


class ProjectController extends Controller
{

    /** @var  ProjectRepository */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepository = $projectRepo;
    }

    public function index()
    {

        // $projects = Project::select('projects.id', 'users.name as usName', 'projects.name as proName', 'projects.company')
        // ->join('users', 'users.id', '=', 'projects.user_id')
        // ->paginate(5);

        // $projects = $this->projectRepository->paginate(5);

        return view('backend.projects.index');
    }

    /**
     * Show the form for creating a new project.
     *
     * @return Response
     */
    public function create()
    {
        $customers = User::where('type', '=', 'customer')->pluck('name', 'id');

        return view('backend.projects.create', compact('customers'));
    }

    /**
     * Store a newly created projects in storage.
     *
     * @param CreateProjectRequest $request
     *
     * @return Response
     */
    public function store(CreateProjectRequest $request)
    {
        $input = $request->all();

        try {
            $projects = $this->projectRepository->create($input);
            $lastProjectId = $projects->id;

            foreach ($request['variable'] as $key => $value) {

                $values = DB::table('data_variables')->select('id')->where('name', '=', $value)->first();

                ProjectVariable::create([
                    'project_id' => $lastProjectId,
                    'data_variable_id' => $values->id,
                ]);
            }

            Flash::success('Proyecto Guardado con Exito.');
        } catch (\Throwable $th) {
            // throw $th;
            Flash::error(__('The project already exists'));
        }

        return redirect(route('admin.projects.index'));
    }

    /**
     * Display the specified project.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // $project = $this->projectRepository->find($id);

        $project = Project::select('projects.id', 'users.name as usName', 'projects.name as proName', 'projects.company', 'projects.company', 'projects.start_date', 'projects.end_date')
            ->join('users', 'users.id', '=', 'projects.user_id')
            ->where('projects.id', '=', $id)
            ->first();

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('admin.projects.index'));
        }

        return view('backend.projects.show')->with('project', $project);
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customers = User::where('type', '=', 'customer')->pluck('name', 'id');

        $project = $this->projectRepository->find($id);

        $projects = ProjectVariable::select(
            'data_variables.name as datName',
            'type_variables.name as service',
            'projects.name',
            'projects.description',
            'projects.company',
            'projects.start_date',
            'projects.end_date'
        )
            ->join('data_variables', 'project_variables.data_variable_id', '=', 'data_variables.id')
            ->join('type_variables', 'data_variables.type_variable_id', '=', 'type_variables.id')
            ->join('projects', 'project_variables.project_id', '=', 'projects.id')
            ->where('project_id', $id)->get();

        // dd($projects);

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('admin.projects.index'));
        }

        return view('backend.projects.edit', compact('project', 'customers', 'projects'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param int $id
     * @param UpdateProjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProjectRequest $request)
    {
        $project = $this->projectRepository->find($id);

        $projectVar = ProjectVariable::where('project_id', $id)->forceDelete();

        foreach ($request['variable'] as $key => $value) {
            $values = DB::table('data_variables')->select('id')->where('name', '=', $value)->first();

            ProjectVariable::create([
                'project_id' => $id,
                'data_variable_id' => $values->id,
            ]);
        }

        if (empty($project)) {
            Flash::error('project not found');

            return redirect(route('admin.projects.index'));
        }

        $input = $request->all();

        if(isset($input['start_date']) && isset($input['end_date'])) {
            $project->update(array(
                'start_date' => $input['start_date'], 
                'end_date' => $input['end_date'],
            ));
        }

        $project->update(array(
            'name' => $input['name'], 
            'description' => $input['description'],
            'company' => $input['company'],
            'user_id' => $input['user_id']
        ));

        Flash::success('Proyecto Actualizado con Exito.');

        return redirect(route('admin.projects.index'));
    }

    /**
     * Remove the specified project from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $project = $this->projectRepository->find($id);

        ProjectVariable::where('project_id', $id)->forceDelete();

        if (empty($project)) {
            Flash::error('Project not found');

            return redirect(route('admin.projects.index'));
        }

        $this->projectRepository->delete($id);

        Flash::success('Proyecto eliminado con Exito.');

        return redirect(route('admin.projects.index'));
    }


    public function getTypeVariables()
    {
        $typeVariable = Type_variable::select('id', 'name')
            ->orderBy('name')
            ->get();

        $typeVariable_json = json_encode($typeVariable);
        return $typeVariable_json;
    }

    public function getDataVariables()
    {
        $dataVariable = DataVariable::select('id', 'name')
            ->orderBy('name')
            ->get();

        $dataVariable_json = json_encode($dataVariable);
        return $dataVariable_json;
    }

    public function getDataVariableForTv(Request $request)
    {
        $input = $request->all();
        $typeVariableId = $input['typeVariableId'];

        $dataVariableIdData = DataVariable::select('id', 'name')
            ->where('type_variable_id', $typeVariableId)
            ->get();

        $dataVariableIdData_json = $dataVariableIdData->toJson();

        return $dataVariableIdData_json;
    }

    public function variableForTypeVariable()
    {
        $dataVariable = DB::table('type_variables')->select('data_variables.id as dataId', 'data_variables.name as dataVar', 'type_variables.name as typeVar', 'type_variables.id as typeId')
            ->join('data_variables', 'type_variables.id', '=', 'data_variables.type_variable_id')
            ->get();

        $dataVariable_json = $dataVariable->toJson();

        return $dataVariable_json;
    }

    public function getProject()
    {
        $customer = auth()->id();

        $date = Carbon::now();

        $projects = Project::select('name', 'id')
            ->where('user_id', $customer)
            ->where(DB::raw('DATE_ADD(end_date, INTERVAL 31 day)'), '>=', $date)
            ->get();

        $userProjects_json = $projects->toJson();

        return $userProjects_json;
    }
}

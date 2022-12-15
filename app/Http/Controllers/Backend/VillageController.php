<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateVillageRequest;
use App\Http\Requests\Backend\UpdateVillageRequest;
use App\Repositories\Backend\VillageRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Backend\Village;
use Illuminate\Http\Request;
use Flash;
use Response;

class VillageController extends AppBaseController
{
    /** @var  VillageRepository */
    private $villageRepository;

    public function __construct(VillageRepository $villageRepo)
    {
        $this->villageRepository = $villageRepo;
    }

    /**
     * Display a listing of the Village.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $villages = $this->villageRepository->paginate(5);

        return view('backend.villages.index')
            ->with('villages', $villages);
    }

    /**
     * Show the form for creating a new Village.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.villages.create');
    }

    /**
     * Store a newly created Village in storage.
     *
     * @param CreateVillageRequest $request
     *
     * @return Response
     */
    public function store(CreateVillageRequest $request)
    {
        $input = $request->all();

        $village = $this->villageRepository->create($input);

        Flash::success('Municipios Guardado con Exito.');

        return redirect(route('admin.villages.index'));
    }

    /**
     * Display the specified Village.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            Flash::error('Village not found');

            return redirect(route('admin.villages.index'));
        }

        return view('backend.villages.show')->with('village', $village);
    }

    /**
     * Show the form for editing the specified Village.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            Flash::error('Village not found');

            return redirect(route('admin.villages.index'));
        }

        return view('backend.villages.edit')->with('village', $village);
    }

    /**
     * Update the specified Village in storage.
     *
     * @param int $id
     * @param UpdateVillageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVillageRequest $request)
    {
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            Flash::error('Village not found');

            return redirect(route('admin.villages.index'));
        }

        $village = $this->villageRepository->update($request->all(), $id);

        Flash::success('Municipio Actualizado con Exito.');

        return redirect(route('admin.villages.index'));
    }

    /**
     * Remove the specified Village from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            Flash::error('Village not found');

            return redirect(route('admin.villages.index'));
        }

        $resultQueriesOne = Village::select('villages.id', 'areas.village_id')
            ->Join('areas', 'villages.id', '=', 'areas.village_id')
            ->where('villages.id', '=', $id)
            ->get();

        if (count($resultQueriesOne) > 0) {
            Flash::error('El municipio no se puede eliminar porque posee areas asociadas.');
            return redirect(route('admin.villages.index'));
        }

        $village->forceDelete();

        Flash::success('Municipio eliminado con Exito.');

        return redirect(route('admin.villages.index'));
    }
}

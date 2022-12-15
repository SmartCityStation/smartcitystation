<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateAreaRequest;
use App\Http\Requests\Backend\UpdateAreaRequest;
use App\Repositories\Backend\AreaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Backend\Village;

class AreaController extends AppBaseController
{
    /** @var  AreaRepository */
    private $areaRepository;

    public function __construct(AreaRepository $areaRepo)
    {
        $this->areaRepository = $areaRepo;
    }

    /**
     * Display a listing of the Area.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $areas = $this->areaRepository->paginate(5);

        return view('backend.areas.index')
            ->with('areas', $areas);
    }

    /**
     * Show the form for creating a new Area.
     *
     * @return Response
     */
    public function create()
    {
        $villages = Village::pluck('name', 'id');
        return view('backend.areas.create')->with(compact('villages'));
        // return view('backend.areas.create');
    }

    /**
     * Store a newly created Area in storage.
     *
     * @param CreateAreaRequest $request
     *
     * @return Response
     */
    public function store(CreateAreaRequest $request)
    {
        $input = $request->all();

        $area = $this->areaRepository->create($input);

        Flash::success('Area Guardado con Exito.');

        return redirect(route('admin.areas.index'));
    }

    /**
     * Display the specified Area.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            Flash::error('Area not found');

            return redirect(route('admin.areas.index'));
        }

        return view('backend.areas.show')->with('area', $area);
    }

    /**
     * Show the form for editing the specified Area.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $villages = Village::pluck('name', 'id');

        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            Flash::error('Area not found');

            return redirect(route('admin.areas.index'));
        }

        return view('backend.areas.edit')->with(compact('area', 'villages'));
        // return view('backend.areas.edit')->with('area', $area);
    }

    /**
     * Update the specified Area in storage.
     *
     * @param int $id
     * @param UpdateAreaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAreaRequest $request)
    {
        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            Flash::error('Area not found');

            return redirect(route('admin.areas.index'));
        }

        $area = $this->areaRepository->update($request->all(), $id);

        Flash::success('Area Actualizado con Exito.');

        return redirect(route('admin.areas.index'));
    }

    /**
     * Remove the specified Area from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $area = $this->areaRepository->find($id);

        if (empty($area)) {
            Flash::error('Area not found');

            return redirect(route('admin.areas.index'));
        }

        $this->areaRepository->delete($id);

        Flash::success('Area Eliminado con Exito.');

        return redirect(route('admin.areas.index'));
    }
}

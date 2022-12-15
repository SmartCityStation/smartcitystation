<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateVillageAPIRequest;
use App\Http\Requests\API\Backend\UpdateVillageAPIRequest;
use App\Models\Backend\Village;
use App\Repositories\Backend\VillageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VillageController
 * @package App\Http\Controllers\API\Backend
 */

class VillageAPIController extends AppBaseController
{
    /** @var  VillageRepository */
    private $villageRepository;

    public function __construct(VillageRepository $villageRepo)
    {
        $this->villageRepository = $villageRepo;
    }

    /**
     * Display a listing of the Village.
     * GET|HEAD /villages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $villages = $this->villageRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($villages->toArray(), 'Villages retrieved successfully');
    }

    /**
     * Store a newly created Village in storage.
     * POST /villages
     *
     * @param CreateVillageAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVillageAPIRequest $request)
    {
        $input = $request->all();

        $village = $this->villageRepository->create($input);

        return $this->sendResponse($village->toArray(), 'Village saved successfully');
    }

    /**
     * Display the specified Village.
     * GET|HEAD /villages/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Village $village */
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            return $this->sendError('Village not found');
        }

        return $this->sendResponse($village->toArray(), 'Village retrieved successfully');
    }

    /**
     * Update the specified Village in storage.
     * PUT/PATCH /villages/{id}
     *
     * @param int $id
     * @param UpdateVillageAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVillageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Village $village */
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            return $this->sendError('Village not found');
        }

        $village = $this->villageRepository->update($input, $id);

        return $this->sendResponse($village->toArray(), 'Village updated successfully');
    }

    /**
     * Remove the specified Village from storage.
     * DELETE /villages/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Village $village */
        $village = $this->villageRepository->find($id);

        if (empty($village)) {
            return $this->sendError('Village not found');
        }

        $village->delete();

        return $this->sendSuccess('Village deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateVariableDeviceAPIRequest;
use App\Http\Requests\API\Backend\UpdateVariableDeviceAPIRequest;
use App\Models\Backend\VariableDevice;
use App\Repositories\Backend\VariableDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VariableDeviceController
 * @package App\Http\Controllers\API\Backend
 */

class VariableDeviceAPIController extends AppBaseController
{
    /** @var  VariableDeviceRepository */
    private $variableDeviceRepository;

    public function __construct(VariableDeviceRepository $variableDeviceRepo)
    {
        $this->variableDeviceRepository = $variableDeviceRepo;
    }

    /**
     * Display a listing of the VariableDevice.
     * GET|HEAD /variableDevices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $variableDevices = $this->variableDeviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($variableDevices->toArray(), 'Variable Devices retrieved successfully');
    }

    /**
     * Store a newly created VariableDevice in storage.
     * POST /variableDevices
     *
     * @param CreateVariableDeviceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVariableDeviceAPIRequest $request)
    {
        $input = $request->all();

        $variableDevice = $this->variableDeviceRepository->create($input);

        return $this->sendResponse($variableDevice->toArray(), 'Variable Device saved successfully');
    }

    /**
     * Display the specified VariableDevice.
     * GET|HEAD /variableDevices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VariableDevice $variableDevice */
        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            return $this->sendError('Variable Device not found');
        }

        return $this->sendResponse($variableDevice->toArray(), 'Variable Device retrieved successfully');
    }

    /**
     * Update the specified VariableDevice in storage.
     * PUT/PATCH /variableDevices/{id}
     *
     * @param int $id
     * @param UpdateVariableDeviceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVariableDeviceAPIRequest $request)
    {
        $input = $request->all();

        /** @var VariableDevice $variableDevice */
        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            return $this->sendError('Variable Device not found');
        }

        $variableDevice = $this->variableDeviceRepository->update($input, $id);

        return $this->sendResponse($variableDevice->toArray(), 'VariableDevice updated successfully');
    }

    /**
     * Remove the specified VariableDevice from storage.
     * DELETE /variableDevices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VariableDevice $variableDevice */
        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            return $this->sendError('Variable Device not found');
        }

        $variableDevice->delete();

        return $this->sendSuccess('Variable Device deleted successfully');
    }
}

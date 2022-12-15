<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateDataVariableAPIRequest;
use App\Http\Requests\API\Backend\UpdateDataVariableAPIRequest;
use App\Models\Backend\DataVariable;
use App\Repositories\Backend\DataVariableRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class DataVariableController
 * @package App\Http\Controllers\API\Backend
 */

class DataVariableAPIController extends AppBaseController
{
    /** @var  DataVariableRepository */
    private $dataVariableRepository;

    public function __construct(DataVariableRepository $dataVariableRepo)
    {
        $this->dataVariableRepository = $dataVariableRepo;
    }

    /**
     * Display a listing of the DataVariable.
     * GET|HEAD /dataVariables
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $dataVariables = $this->dataVariableRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($dataVariables->toArray(), 'Data Variables retrieved successfully');
    }

    /**
     * Store a newly created DataVariable in storage.
     * POST /dataVariables
     *
     * @param CreateDataVariableAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDataVariableAPIRequest $request)
    {
        $input = $request->all();

        $dataVariable = $this->dataVariableRepository->create($input);

        return $this->sendResponse($dataVariable->toArray(), 'Data Variable saved successfully');
    }

    /**
     * Display the specified DataVariable.
     * GET|HEAD /dataVariables/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DataVariable $dataVariable */
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            return $this->sendError('Data Variable not found');
        }

        return $this->sendResponse($dataVariable->toArray(), 'Data Variable retrieved successfully');
    }

    /**
     * Update the specified DataVariable in storage.
     * PUT/PATCH /dataVariables/{id}
     *
     * @param int $id
     * @param UpdateDataVariableAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDataVariableAPIRequest $request)
    {
        $input = $request->all();

        /** @var DataVariable $dataVariable */
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            return $this->sendError('Data Variable not found');
        }

        $dataVariable = $this->dataVariableRepository->update($input, $id);

        return $this->sendResponse($dataVariable->toArray(), 'DataVariable updated successfully');
    }

    /**
     * Remove the specified DataVariable from storage.
     * DELETE /dataVariables/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DataVariable $dataVariable */
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            return $this->sendError('Data Variable not found');
        }

        $dataVariable->delete();

        return $this->sendSuccess('Data Variable deleted successfully');
    }
}

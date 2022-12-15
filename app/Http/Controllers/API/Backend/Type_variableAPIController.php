<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateType_variableAPIRequest;
use App\Http\Requests\API\Backend\UpdateType_variableAPIRequest;
use App\Models\Backend\Type_variable;
use App\Repositories\Backend\Type_variableRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class Type_variableController
 * @package App\Http\Controllers\API\Backend
 */

class Type_variableAPIController extends AppBaseController
{
    /** @var  Type_variableRepository */
    private $typeVariableRepository;

    public function __construct(Type_variableRepository $typeVariableRepo)
    {
        $this->typeVariableRepository = $typeVariableRepo;
    }

    /**
     * Display a listing of the Type_variable.
     * GET|HEAD /typeVariables
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $typeVariables = $this->typeVariableRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($typeVariables->toArray(), 'Type Variables retrieved successfully');
    }

    /**
     * Store a newly created Type_variable in storage.
     * POST /typeVariables
     *
     * @param CreateType_variableAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateType_variableAPIRequest $request)
    {
        $input = $request->all();

        $typeVariable = $this->typeVariableRepository->create($input);

        return $this->sendResponse($typeVariable->toArray(), 'Type Variable saved successfully');
    }

    /**
     * Display the specified Type_variable.
     * GET|HEAD /typeVariables/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Type_variable $typeVariable */
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            return $this->sendError('Type Variable not found');
        }

        return $this->sendResponse($typeVariable->toArray(), 'Type Variable retrieved successfully');
    }

    /**
     * Update the specified Type_variable in storage.
     * PUT/PATCH /typeVariables/{id}
     *
     * @param int $id
     * @param UpdateType_variableAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateType_variableAPIRequest $request)
    {
        $input = $request->all();

        /** @var Type_variable $typeVariable */
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            return $this->sendError('Type Variable not found');
        }

        $typeVariable = $this->typeVariableRepository->update($input, $id);

        return $this->sendResponse($typeVariable->toArray(), 'Type_variable updated successfully');
    }

    /**
     * Remove the specified Type_variable from storage.
     * DELETE /typeVariables/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Type_variable $typeVariable */
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            return $this->sendError('Type Variable not found');
        }

        $typeVariable->delete();

        return $this->sendSuccess('Type Variable deleted successfully');
    }
}

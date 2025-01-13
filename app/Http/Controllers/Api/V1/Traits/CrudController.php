<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Traits\ExceptionResponse;
use App\Http\Controllers\Api\V1\Traits\HasForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

abstract class CrudController extends Controller
{
    use HasForm;
    use ExceptionResponse;

    protected $repository;
    protected $columns;
    protected $model;

    public function __construct($repository)
    {
        $this->repository = $repository;
        $this->model      = app($this->model);
        $this->columns    = Schema::getColumnListing($this->model->getTable());
    }

    public function index()
    {
        $queryParams = request()->query();
        return $this->repository->all($queryParams);
    }

    public function store()
    {
        $params = $this->formParams();

        try {
            return $this->repository->create($params);
        } catch (\Exception $ex) {
            return $this->exceptionMessage($ex);
        }
    }

    public function show($id)
    {
        $resource = $this->repository->find($id);

        if (!$resource) {
            return $this->responseMessage('error', 'Recurso não encontrado', $code = 422);
        }

        return $resource;
    }

    public function update($id)
    {
        $resource = $this->repository->find($id);

        if (!$resource) {
            return $this->responseMessage('error', 'Recurso não encontrado', $code = 422);
        }

        return $this->repository->update($resource, $this->formParams());
    }

    public function destroy($id)
    {
        try {
            $resource = $this->repository->find($id);

            if (!$resource) {
                return $this->responseMessage('error', 'Recurso não encontrado', $code = 422);
            }

            return $this->repository->delete($resource);
        } catch (\Exception $ex) {
            return $this->exceptionMessage($ex);
        }
    }
}

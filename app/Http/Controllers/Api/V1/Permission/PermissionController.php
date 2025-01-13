<?php

namespace App\Http\Controllers\Api\V1\Permission;

use App\Http\Controllers\Api\V1\CrudController;
use App\Http\Requests\Api\V1\Permission\PermissionRequest;
use App\Http\Requests\Api\V1\Permission\PermissionSyncRequest;
use App\Repositories\Api\V1\Permission\PermissionRepository;
use Spatie\Permission\Models\Permission;

class PermissionController extends CrudController
{
    protected $model = Permission::class;

    public function __construct()
    {
        $this->repository = new PermissionRepository();
    }

    public function sync(PermissionSyncRequest $request)
    {
        $permission = $request->validated();

        $this->repository->sync($permission);
        return response()->json(['message' => 'Permissions synchronized successfully']);
    }

    public function listGroup()
    {
        return $this->repository->listGroup();
    }


    public function formRequest(): PermissionRequest
    {
        return app(PermissionRequest::class);
    }
}

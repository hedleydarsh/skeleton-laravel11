<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Http\Controllers\Api\V1\CrudController;
use App\Http\Requests\Api\V1\Role\RoleRequest;
use App\Repositories\Api\V1\Role\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends CrudController
{
    protected $model = Role::class;

    public function __construct()
    {
        $this->repository = new RoleRepository();
    }

    public function sync($roleName, Request $request)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'required|string',
        ]);

        $permissions = $validated['permissions'];

        $this->repository->sync($roleName, $permissions);
        return response()->json(['message' => 'Permissions synchronized successfully']);
    }

    public function formRequest(): RoleRequest
    {
        return app(RoleRequest::class);
    }
}

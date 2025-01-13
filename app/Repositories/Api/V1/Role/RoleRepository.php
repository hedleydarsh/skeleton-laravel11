<?php

namespace App\Repositories\Api\V1\Role;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    protected $model = Role::class;

    public function sync(string $roleName, array $permissions)
    {
        $role = $this->model->where('name', $roleName)->first();
        $role->syncPermissions($permissions);

        return $role;
    }
}

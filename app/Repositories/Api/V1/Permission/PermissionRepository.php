<?php

namespace App\Repositories\Api\V1\Permission;

use App\Constants\Constants;
use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRepository extends BaseRepository
{
    protected $model = Permission::class;

    public function all($queryParams)
    {
        $permissions = $this->model->all();
        $data = [];

        foreach ($permissions as $permission) {
            // Extrai o módulo do nome da permissão
            [$module, $action] = explode('_', $permission->name, 2);

            // Adiciona a permissão à lista do módulo
            $roles = $permission->roles->pluck('name')->toArray();
            foreach ($roles as $role) {
                $data[$module][$role][] = $action;
            }
        }

        return response()->json($data);
    }

    public function sync(array $permission)
    {
        $role = Role::where('name', $permission['role'])->first();
        $permissionChange = $permission['permission'];

        if ($permissionChange['active']) {
            $role->givePermissionTo($permissionChange['name']);
        } else {
            $role->revokePermissionTo($permissionChange['name']);
        }

        return $role->load('permissions');
    }

    public function listGroup()
    {
        $permissions = $this->model->get();
        $roles = Role::get();

        $data = [];

        foreach ($permissions as $permission) {
            // Extrai o módulo do nome da permissão
            [$module, $action] = explode('_', $permission->name, 2);

            // Adiciona a permissão à lista do módulo
            if (!isset($data[$module])) {
                $data[$module]['title'] = Constants::PERMISSIONS[$module] ?? ucfirst($module); // Adiciona o título do módulo
                $data[$module]['roles'] = [];
            }

            // Adiciona a role ao array se ainda não estiver presente
            foreach ($roles as $role) {
                $roleName = $role->name;
                $roleTitle = $role->title ?? ucfirst($roleName); // Verifica se existe um título definido, senão capitaliza o nome da role

                // Verifica se a role já foi adicionada ao módulo
                $roleExists = collect($data[$module]['roles'])->where('name', $roleName)->first();

                if (!$roleExists) {
                    $activePermissions = $role->permissions->pluck('name')->toArray();

                    $permissionsArray = [];
                    foreach (['list', 'create', 'edit', 'delete'] as $permAction) {
                        $permissionsArray[] = [
                            'title' => "{$module}_{$permAction}",
                            'active' => in_array("{$module}_{$permAction}", $activePermissions),
                        ];
                    }

                    $data[$module]['roles'][] = [
                        'name' => $roleName,
                        'title' => $roleTitle,
                        'permissions' => $permissionsArray,
                    ];
                }
            }
        }

        return response()->json(array_values($data));
    }
}
